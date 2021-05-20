<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Mailer\EmailFactory;
use App\Message\EmailMessage;
use App\Model\Security\SendResetPasswordEmailDTO;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SendResetPasswordEmailController extends AbstractController
{
    private ValidatorInterface $validator;

    private UserRepository $userRepository;

    private EmailFactory $emailFactory;

    private MessageBusInterface $bus;

    private TranslatorInterface $translator;

    public function __construct(
        ValidatorInterface $validator,
        UserRepository $userRepository,
        MessageBusInterface $bus,
        EmailFactory $emailFactory,
        TranslatorInterface $translator
    ) {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
        $this->bus = $bus;
        $this->emailFactory = $emailFactory;
        $this->translator = $translator;
    }

    public function __invoke(SendResetPasswordEmailDTO $data, Request $request): JsonResponse
    {
        if (count($errors = $this->validator->validate($data)) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->findOneBy([
            'email' => $data->email,
        ]);

        if (null === $user) {
            return $this->json(['message' => 'EMAIL_SENT']);
        }

        $token = Uuid::v4()->toRfc4122();

        $user->setResetPasswordToken($token);
        $user->setResetPasswordExpirationDate(new \DateTimeImmutable('+1 hours'));
        $user->hasBeenUpdated();

        $this->userRepository->save($user);

        $email = $this->emailFactory->createForResetPassword(
            $user,
            $token,
            $this->translator->trans('subject', [], 'reset-email')
        );

        $this->bus->dispatch(new EmailMessage($email, $request->getLocale()));

        return $this->json(['message' => 'EMAIL_SENT']);
    }
}

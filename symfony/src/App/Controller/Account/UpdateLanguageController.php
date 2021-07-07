<?php

declare(strict_types=1);

namespace App\Controller\Account;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Model\Account\Enum\LanguageEnum;
use Model\Account\UpdateLanguageDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateLanguageController extends AbstractController
{
    public const PATH = '/account/update-language';

    public function __construct(
        private ValidatorInterface $validator,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(UpdateLanguageDTO $data): JsonResponse
    {
        $this->validator->validate($data);

        /** @var User $user */
        $user = $this->getUser();

        if ($user->getLanguage() === $language = LanguageEnum::resolveLanguage($data->language)) {
            return $this->json(null);
        }

        $user->setLanguage($language);
        $this->userRepository->save($user);

        return $this->json(null);
    }
}

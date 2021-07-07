<?php

declare(strict_types=1);

namespace Domain\User\DataTransformer;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use Model\Account\Enum\LanguageEnum;
use Model\User\CreateUserDTO;

final class CreateUserDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @param CreateUserDTO $object
     *
     * @throws ValidationException
     */
    public function transform($object, string $to, array $context = []): User
    {
        $this->validator->validate($object);
        $user = new User();

        $user
            ->setPassword($object->getPassword())
            ->setNickname($object->getNickname())
            ->setLanguage(LanguageEnum::resolveLanguage($object->getLanguage()))
            ->setEmail($object->getEmail());

        return $user;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return isset($context['input']['class']) && CreateUserDTO::class === $context['input']['class'];
    }
}

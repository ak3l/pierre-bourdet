<?php

declare(strict_types=1);

namespace Model\Account;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Account\UpdateLanguageController;
use Model\Account\Enum\LanguageEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'updateLanguage' => [
            'path' => UpdateLanguageController::PATH,
            'controller' => UpdateLanguageController::class,
            'input' => UpdateLanguageDTO::class,
            'output' => false,
            'method' => Request::METHOD_POST,
            'openapi_context' => [
                'tags' => ['Account'],
                'summary' => 'A user can update his language.',
                'description' => 'A user can update his language.',
                'responses' => [
                    Response::HTTP_OK => [
                        'description' => 'Language successfully updated.',
                        'content' => [
                            'application/json' => [],
                        ],
                    ],
                    Response::HTTP_BAD_REQUEST => [
                        'description' => 'Input data is not valid.',
                        'content' => [
                            'application/json' => [],
                        ],
                    ],
                ],
            ],
        ],
    ],
    itemOperations: [],
    formats: ['json']
)]
class UpdateLanguageDTO
{
    #[Assert\Choice(callback: [LanguageEnum::class, 'getIsoLanguages'])]
    public string $language;
}

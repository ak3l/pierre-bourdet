<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * See https://api-platform.com/docs/core/jwt/#adding-endpoint-to-swaggerui-to-retrieve-a-jwt-token.
 */
final class SwaggerDecorator implements NormalizerInterface
{
    private NormalizerInterface $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * @param array<mixed> $context
     *
     * @return array<array>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $docs['components']['schemas']['Token'] = [
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ];

        $docs['components']['schemas']['Credentials'] = [
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'test@test.fr',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => '123456',
                ],
            ],
        ];

        $tokenDocumentation = [
            'paths' => [
                '/login_check' => [
                    'post' => [
                        'tags' => ['Token'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token to login.',
                        'requestBody' => [
                            'description' => 'Create new JWT Token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Credentials',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return array_merge_recursive($docs, $tokenDocumentation);
    }
}

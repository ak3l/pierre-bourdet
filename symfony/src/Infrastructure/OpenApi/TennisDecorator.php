<?php

declare(strict_types=1);

namespace Infrastructure\OpenApi;

use ApiPlatform\Core\JsonSchema\Schema;
use ApiPlatform\Core\JsonSchema\SchemaFactoryInterface;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\Parameter;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\OpenApi;
use Model\Tennis\PlayerProfile\PlayerProfile;
use Model\Tennis\Rankings\Ranking;
use Symfony\Component\HttpFoundation\Response;

class TennisDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated,
        private SchemaFactoryInterface $schemaFactory
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        /** @var \ArrayObject $schemas */
        $schemas = $openApi->getComponents()->getSchemas();

        $singlesRankingsPath = $this->createSinglesRankingsPath($schemas);
        $playerProfilePath = $this->createPlayerProfilePath($schemas);

        $openApi->getPaths()->addPath('/tennis/singles-rankings/{competitionName}', $singlesRankingsPath);
        $openApi->getPaths()->addPath('/tennis/player-profile/{playerId}', $playerProfilePath);

        return $openApi;
    }

    private function createSinglesRankingsPath(\ArrayObject $schemas): PathItem
    {
        $schema = new Schema(Schema::VERSION_OPENAPI);
        $schema->setDefinitions($schemas);

        $this->schemaFactory->buildSchema(Ranking::class, format: 'json', schema: $schema);

        return new PathItem(
            get: new Operation(
                operationId: 'getSinglesRanking',
                tags: ['Tennis'],
                responses: [
                    Response::HTTP_OK => [
                        'description' => 'Rankings successfully retrieved.',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Ranking',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Get singles ranking by competition type.',
                parameters: [new Parameter('competitionName', 'path', 'Competition name', required: true)],
                security: [],
            ),
        );
    }

    public function createPlayerProfilePath(\ArrayObject $schemas): PathItem
    {
        $schema = new Schema(Schema::VERSION_OPENAPI);
        $schema->setDefinitions($schemas);

        $this->schemaFactory->buildSchema(PlayerProfile::class, format: 'json', schema: $schema);

        return new PathItem(
            get: new Operation(
                operationId: 'getPlayerProfile',
                tags: ['Tennis'],
                responses: [
                    Response::HTTP_OK => [
                        'description' => 'Player profile successfully retrieved.',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/PlayerProfile',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Get player profile.',
                parameters: [new Parameter('playerId', 'path', 'Player id', required: true)],
                security: [],
            ),
        );
    }
}

<?php

declare(strict_types=1);

namespace Domain\Tennis;

use Model\Tennis\Exception\SportRadarApiException;
use Model\Tennis\PlayerProfile\PlayerProfile;
use Model\Tennis\Rankings\RankingsBaseClass;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SportRadarClient
{
    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer,
        private LoggerInterface $logger
    ) {
    }

    public function getSinglesRankings(): RankingsBaseClass
    {
        return $this->request(
            '/tennis/trial/v3/en/rankings.json',
            RankingsBaseClass::class
        );
    }

    public function getPlayerProfile(int $playerId): object
    {
        return $this->request(
            sprintf('/tennis/trial/v3/en/competitors/sr:competitor:%s/profile.json', $playerId),
            PlayerProfile::class
        );
    }

    private function request(string $url, string $outputClass): mixed
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            $url
        );

        $content = $response->getContent(false);

        if ($response->getStatusCode() >= 400) {
            $this->logger->error(
                sprintf('Error when calling URL %s with status code %s', $url, $response->getStatusCode()),
                [
                    'message' => $content,
                ]
            );

            throw new SportRadarApiException($response->getStatusCode(), $content, );
        }

        return $this->serializer->deserialize(
            $content,
            $outputClass,
            'json'
        );
    }
}

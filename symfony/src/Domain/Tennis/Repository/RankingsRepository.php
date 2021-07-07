<?php

declare(strict_types=1);

namespace Domain\Tennis\Repository;

use Domain\Tennis\SportRadarClient;
use Model\Tennis\Exception\RankingNotFoundException;
use Model\Tennis\Rankings\Ranking;

class RankingsRepository
{
    public function __construct(
        private SportRadarClient $client
    ) {
    }

    public function getSinglesRankingsByName(string $name): Ranking
    {
        $rankingsBaseClass = $this->client->getSinglesRankings();

        foreach ($rankingsBaseClass->rankings as $ranking) {
            if ($name === $ranking->name) {
                return $ranking;
            }
        }

        throw new RankingNotFoundException($name);
    }
}

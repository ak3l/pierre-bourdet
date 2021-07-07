<?php

declare(strict_types=1);

namespace Model\Tennis\Rankings;

class Ranking
{
    public int $typeId = 0;

    public string $name = '';

    public int $year = 0;

    public int $week = 0;

    public string $gender = '';

    /** @var CompetitorRanking[] */
    public array $competitorRankings = [];
}

<?php

declare(strict_types=1);

namespace Model\Tennis\Rankings;

use Model\Tennis\PlayerProfile\Competitor;

class CompetitorRanking
{
    public int $rank = 0;

    public int $movement = 0;

    public int $points = 0;

    public int $competitionsPlayed = 0;

    public string $type = '';

    public string $name = '';

    public string $competitorId = '';

    public bool $raceRanking = false;

    public Competitor $competitor;

    public function __construct()
    {
        $this->competitor = new Competitor();
    }
}

<?php

declare(strict_types=1);

namespace Model\Tennis\Rankings;

use Model\Tennis\PlayerProfile\Competitor;
use Model\Tennis\PlayerProfile\PlayerProfile;
use Symfony\Component\Serializer\Annotation as Serializer;

class CompetitorRanking
{
    #[Serializer\Groups([PlayerProfile::READ, Ranking::READ])]
    public int $rank = 0;

    #[Serializer\Groups([Ranking::READ, Ranking::READ])]
    public int $movement = 0;

    #[Serializer\Groups([PlayerProfile::READ, Ranking::READ])]
    public int $points = 0;

    #[Serializer\Groups([Ranking::READ])]
    public int $competitionsPlayed = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public string $type = '';

    public string $name = '';

    public string $competitorId = '';

    public bool $raceRanking = false;

    #[Serializer\Groups([Ranking::READ])]
    public Competitor $competitor;

    public function __construct()
    {
        $this->competitor = new Competitor();
    }
}

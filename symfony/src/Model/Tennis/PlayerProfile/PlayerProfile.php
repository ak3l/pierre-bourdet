<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

use Model\Tennis\Rankings\CompetitorRanking;

class PlayerProfile
{
    public Competitor $competitor;

    public PlayerInformation $info;

    /** @var CompetitorRanking[] */
    public array $competitorRankings = [];

    /** @var Period[] */
    public array $periods = [];

    /** @var Competition[] */
    public array $competitionsPlayed = [];

    public function __construct()
    {
        $this->competitor = new Competitor();
        $this->info = new PlayerInformation();
    }
}

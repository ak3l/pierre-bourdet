<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

use Model\Tennis\Rankings\CompetitorRanking;
use Symfony\Component\Serializer\Annotation as Serializer;

class PlayerProfile
{
    public const READ = 'player-profile:read';

    #[Serializer\Groups([PlayerProfile::READ])]
    public Competitor $competitor;

    #[Serializer\Groups([PlayerProfile::READ])]
    public PlayerInformation $info;

    /** @var CompetitorRanking[] */
    #[Serializer\Groups([PlayerProfile::READ])]
    public array $competitorRankings = [];

    /** @var Period[] */
    #[Serializer\Groups([PlayerProfile::READ])]
    public array $periods = [];

    /** @var Competition[] */
    public array $competitionsPlayed = [];

    public function __construct()
    {
        $this->competitor = new Competitor();
        $this->info = new PlayerInformation();
    }
}

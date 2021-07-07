<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

use Symfony\Component\Serializer\Annotation as Serializer;

class Statistics
{
    #[Serializer\Groups([PlayerProfile::READ])]
    public int $competitionsPlayed = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public int $competitionsWon = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public int $matchesPlayed = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public int $matchesWon = 0;
}

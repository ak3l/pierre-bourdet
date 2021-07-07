<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

use Symfony\Component\Serializer\Annotation as Serializer;

class PlayerInformation
{
    #[Serializer\Groups([PlayerProfile::READ])]
    public int $proYear = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public string $handedness = '';

    #[Serializer\Groups([PlayerProfile::READ])]
    public int $highestSinglesRanking = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public int $highestDoublesRanking = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public int $weight = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public int $height = 0;

    #[Serializer\Groups([PlayerProfile::READ])]
    public \DateTime $dateOfBirth;

    #[Serializer\Groups([PlayerProfile::READ])]
    public string $highestSinglesRankingDate = '';

    #[Serializer\Groups([PlayerProfile::READ])]
    public string $highestDoublesRankingDate = '';
}

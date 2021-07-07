<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

class PlayerInformation
{
    public int $proYear = 0;

    public string $handedness = '';

    public int $highestSinglesRanking = 0;

    public int $highestDoublesRanking = 0;

    public int $weight = 0;

    public int $height = 0;

    public \DateTime $dateOfBirth;

    public string $highestSinglesRankingDate = '';

    public string $highestDoublesRankingDate = '';
}

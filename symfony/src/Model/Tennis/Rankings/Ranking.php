<?php

declare(strict_types=1);

namespace Model\Tennis\Rankings;

use Symfony\Component\Serializer\Annotation as Serializer;

class Ranking
{
    public const READ = 'ranking:read';

    public int $typeId = 0;

    #[Serializer\Groups([Ranking::READ])]
    public string $name = '';

    #[Serializer\Groups([Ranking::READ])]
    public int $year = 0;

    #[Serializer\Groups([Ranking::READ])]
    public int $week = 0;

    public string $gender = '';

    /** @var CompetitorRanking[] */
    #[Serializer\Groups([Ranking::READ])]
    public array $competitorRankings = [];
}

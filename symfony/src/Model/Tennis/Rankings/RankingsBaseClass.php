<?php

declare(strict_types=1);

namespace Model\Tennis\Rankings;

class RankingsBaseClass
{
    public \DateTime $generatedAt;

    /** @var Ranking[] */
    public array $rankings = [];

    public function __construct()
    {
        $this->generatedAt = new \DateTime();
    }
}

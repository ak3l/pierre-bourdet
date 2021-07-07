<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

class Period
{
    public int $year = 0;

    /** @var Surface[] */
    public array $surfaces = [];

    public Statistics $statistics;

    public function __construct()
    {
        $this->statistics = new Statistics();
    }
}

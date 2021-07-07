<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

use Symfony\Component\Serializer\Annotation as Serializer;

class Period
{
    #[Serializer\Groups([PlayerProfile::READ])]
    public int $year = 0;

    /** @var Surface[] */
    #[Serializer\Groups([PlayerProfile::READ])]
    public array $surfaces = [];

    #[Serializer\Groups([PlayerProfile::READ])]
    public Statistics $statistics;

    public function __construct()
    {
        $this->statistics = new Statistics();
    }
}

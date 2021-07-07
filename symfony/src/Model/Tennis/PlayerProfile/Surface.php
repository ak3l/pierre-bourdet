<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

use Symfony\Component\Serializer\Annotation as Serializer;

class Surface
{
    #[Serializer\Groups([PlayerProfile::READ])]
    public string $type;

    #[Serializer\Groups([PlayerProfile::READ])]
    public Statistics $statistics;

    public function __construct()
    {
        $this->statistics = new Statistics();
    }
}

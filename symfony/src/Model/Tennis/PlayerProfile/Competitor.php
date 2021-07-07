<?php

declare(strict_types=1);

namespace Model\Tennis\PlayerProfile;

use Model\Tennis\Rankings\Ranking;
use Symfony\Component\Serializer\Annotation as Serializer;

class Competitor
{
    #[Serializer\Groups([Ranking::READ])]
    public string $id = '';

    #[Serializer\Groups([PlayerProfile::READ, Ranking::READ])]
    public string $name = '';

    #[Serializer\Groups([PlayerProfile::READ, Ranking::READ])]
    public string $country = '';

    #[Serializer\Groups([Ranking::READ])]
    public string $countryCode = '';

    #[Serializer\Groups([PlayerProfile::READ])]
    public string $abbreviation = '';

    #[Serializer\Groups([PlayerProfile::READ])]
    public string $gender = '';
}

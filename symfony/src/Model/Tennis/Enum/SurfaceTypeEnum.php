<?php

declare(strict_types=1);

namespace Model\Tennis\Enum;

class SurfaceTypeEnum
{
    public const GRASS_TYPE = 'GRASS';
    public const CLAY_TYPE = 'CLAY';
    public const HARD_TYPE = 'HARD';

    public const GRASS = 'grass';
    public const SYNTHETIC_GRASS = 'synthetic_grass';
    public const RED_CLAY = 'red_clay';
    public const GREEN_CLAY = 'green_clay';
    public const RED_CLAY_INDOOR = 'red_clay_indoor';
    public const HARD_COURT = 'hard_court';
    public const HARDCOURT_OUTDOOR = 'hardcourt_outdoor';
    public const HARDCOURT_INDOOR = 'hardcourt_indoor';
    public const CARPET_INDOOR = 'carpet_indoor';
    public const SYNTHETIC_INDOOR = 'synthetic_indoor';
    public const SYNTHETIC_OUTDOOR = 'synthetic_outdoor';
    public const UNKNOWN = 'unknown';

    public static function resolveType(string $surface): string
    {
        switch ($surface) {
            case self::RED_CLAY:
            case self::GREEN_CLAY:
            case self::RED_CLAY_INDOOR:
                return self::CLAY_TYPE;
            case self::GRASS:
            case self::SYNTHETIC_GRASS:
                return self::GRASS_TYPE;
        }

        return self::HARD_TYPE;
    }
}

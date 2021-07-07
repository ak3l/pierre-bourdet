<?php

declare(strict_types=1);

namespace Model\Account\Enum;

final class LanguageEnum
{
    public const EN_ISO639 = 'en-GB';
    public const FR_ISO639 = 'fr-FR';

    public const EN = 'en';
    public const FR = 'fr';

    public const LANGUAGES_MAPPER = [
        self::EN_ISO639 => self::EN,
        self::FR_ISO639 => self::FR,
    ];

    public static function getIsoLanguages(): array
    {
        return [
            self::EN_ISO639,
            self::FR_ISO639,
        ];
    }

    public static function resolveLanguage(string $isoLanguage): string
    {
        return self::LANGUAGES_MAPPER[$isoLanguage];
    }
}

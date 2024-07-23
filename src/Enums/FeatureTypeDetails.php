<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum FeatureTypeDetails : string
{
    case SERVICE_ = "Application Service, manajamenen layanan app.";
    case STRUCTURE_ = "Code structure, data, and algorithms";
    case SECURITY_ = "Fitur keamanan";

    public static function getByName(string $key, bool $isValue = false): self|string|null
    {
        foreach (self::cases() as $case) {
            if ($case->name === $key) {
                return $isValue ? $case->value : $case;
            }
        }
        return null;
    }
}
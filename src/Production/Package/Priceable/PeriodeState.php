<?php

namespace HaschaDev\Production\Package\Priceable;

use HaschaDev\Enums\Periodically;
use Illuminate\Support\Facades\Log;

class PeriodeState
{
    /**
     * ID Language default
     * 
     */
    public static string $defaultLang = "id";

    /**
     * get periodically
     * for data object from database or source code
     * 
     */
    public static function getPeriod(string $period, string $lang = "id"): string
    {
        $result = "";
        try {
            switch ($period) {
                case Periodically::MONTHLY->value:
                    $result = $lang === self::$defaultLang ? "Per Bulan (Monthly)" : "";
                    break;
                case Periodically::ANNUAL->value:
                    $result = $lang === self::$defaultLang ? "Per Tahun (Annual)" : "";
                    break;
                default:
                    $result = $lang === self::$defaultLang ? "" : "No set";
                    break;
            }
        } catch (\Throwable $th) {
            Log::error("#getPeriod error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
        return $result;
    }
}
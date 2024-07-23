<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;
use HaschaDev\Enums\FeatureTypeDetails;

enum FeatureType : string
{
    case SERVICE = "service";
    case STRUCTURE = "structure";
    case SECURITY = "security";

    use Enumerationable;

    /**
     * get all toArray
     * 
     */
    public static function all(): array
    {
        $data = self::data();
        $newData = [];
        foreach($data as $key => $value){
            $newData[] = [
                'name' => $key,
                'value' => $value,
                'details' => FeatureTypeDetails::getByName("{$key}_", true)
            ];
        }
        return $newData;
    }
}
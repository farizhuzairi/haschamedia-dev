<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;
use HaschaDev\Enums\ComponentableType;

enum Componentable : string
{
    case DEFAULT = "default";
    case DEPENDENCY = "dependency";
    case OPTIONAL = "optional";
    case REQUIRED = "required";
    case CONDITIONAL = "conditional";

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
                'details' => ComponentableType::getByName("{$key}_", true)
            ];
        }
        return $newData;
    }
}
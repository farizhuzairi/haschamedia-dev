<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum ComponentType : string
{
    case EXTEND = "extend";
    case INSTANCE = "instance";
    case ABSTRACT = "abstract";
    case IMPLEMENT = "implement";

    use Enumerationable;
}
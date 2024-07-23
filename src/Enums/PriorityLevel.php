<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum PriorityLevel : string
{
    case HIDDEN = "0";
    case LOW = "1";
    case MEDIUM = "2";
    case HIGH = "3";

    use Enumerationable;
}
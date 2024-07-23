<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum Licensable : string
{
    case INCLUDE = "include";
    case EXCLUDE = "exclude";

    use Enumerationable;
}
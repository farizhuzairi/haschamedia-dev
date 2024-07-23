<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum DataServiceable : string
{
    case COLLECTIVE = "collective";
    case INDEPENDENT = "independent";

    use Enumerationable;
}
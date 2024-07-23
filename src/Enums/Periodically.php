<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum Periodically : string
{
    case MONTHLY = "monthly";
    case ANNUAL = "annual";

    use Enumerationable;
}
<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum BaseModel : string
{
    case PACKAGE = "package";
    case Library = "library";
    case Module = "module";
    case ADDON = "add-on";
    case TOOL = "tool";

    use Enumerationable;
}
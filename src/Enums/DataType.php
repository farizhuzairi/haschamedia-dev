<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum DataType : string
{
    case ARR = "array";
    case STR = "string";
    case INT = "int";
    case BOOL = "bool";

    use Enumerationable;
}
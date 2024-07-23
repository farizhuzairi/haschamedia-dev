<?php

namespace HaschaDev\Enums;

enum Roleable : string
{
    case MASTER = "Master";
    case DEV = "Dev";
    case GUEST = "Guest";
}
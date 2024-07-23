<?php

namespace HaschaDev\Database;

enum DBConnect : string
{
    case BASE = "mysql";
    case PRODUCTION = "mysql_production";
    case FILE = "mysql_file";
}
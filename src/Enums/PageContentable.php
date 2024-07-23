<?php

namespace HaschaDev\Enums;

use HaschaDev\Enums\Enumerationable;

enum PageContentable : string
{
    case TEXT = "text";
    case ARTICLE = "article";
    case TAG = "anchor";
    case IMAGE = "image";
    case IMAGES = "images";
    case BANNER = "banner";
    case BANNERS = "banners";

    use Enumerationable;
}
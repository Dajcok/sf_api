<?php

namespace App\Enums;

enum SameSiteEnum: string
{
    case LAX = 'lax';
    case STRICT = 'strict';
    case NONE = 'none';
}

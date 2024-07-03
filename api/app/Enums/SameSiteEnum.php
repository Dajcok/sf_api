<?php

namespace App\Enums;

enum SameSiteEnum: string
{
    case Lax = 'lax';
    case Strict = 'strict';
    case None = 'none';
}

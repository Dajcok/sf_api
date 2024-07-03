<?php

namespace App\Enums;

enum JWTCookieTypeEnum: string
{
    case ACCESS_TOKEN = 'access_token';
    case REFRESH_TOKEN = 'refresh_token';
}

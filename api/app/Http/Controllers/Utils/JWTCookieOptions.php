<?php

namespace App\Http\Controllers\Utils;

use App\Enums\JWTCookieTypeEnum;

class JWTCookieOptions extends CookieOptions
{
    public JWTCookieTypeEnum $type;

    public function __construct(
        $type,
        $value,
    ) {
        parent::__construct(
            $value,
            name: config('jwt.cookie.' . $type . '_name'),
            path: config('jwt.cookie.path'),
            domain: config('jwt.cookie.domain'),
            secure: config('jwt.cookie.secure'),
            httpOnly: config('jwt.cookie.http_only'),
            raw: config('jwt.cookie.raw'),
            expires: config('jwt.cookie.' . $type . '_ttl'),
            sameSite: config('jwt.cookie.same_site')
        );
    }
}

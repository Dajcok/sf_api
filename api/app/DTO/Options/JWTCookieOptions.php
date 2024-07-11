<?php

namespace app\DTO\Options;

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
            name: config('jwt.cookie.' . $type->value . '_name'),
            path: config('jwt.cookie.path'),
            domain: config('jwt.cookie.domain'),
            secure: config('jwt.cookie.secure'),
            httpOnly: config('jwt.cookie.http_only'),
            raw: config('jwt.cookie.raw'),
            expires: config('jwt.cookie.' . $type->value . '_ttl'),
            sameSite: config('jwt.cookie.same_site')
        );
    }
}

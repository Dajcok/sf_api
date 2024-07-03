<?php

namespace App\Http\Controllers\Utils;

use App\Enums\SameSiteEnum;

class CookieOptions
{
    public string $value;
    public string $name;
    public string $expires;
    public string $path;
    public string $domain;
    public bool $secure;
    public bool $httpOnly;
    public bool $raw;
    public SameSiteEnum $sameSite;

    public function __construct(
        string $value,
        string $name,
        string $path,
        string $domain,
        bool $secure,
        bool $httpOnly,
        bool $raw,
        string $expires,
        SameSiteEnum $sameSite
    ) {
        $this->path =  $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        $this->raw = $raw;
        $this->sameSite = $sameSite;
        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires;
    }
}

<?php

namespace App\DTO\Options;

use App\Enums\SameSiteEnum;

class CookieOptions
{
    public string $value;
    public string $name;
    public int $expires;
    public string $path;
    public string $domain;
    public bool $secure;
    public bool $httpOnly;
    public ?bool $raw;
    public ?string $sameSite;

    public function __construct(
        string $value,
        string $name,
        string $path,
        string $domain,
        bool $secure,
        bool $httpOnly,
        ?bool $raw,
        int $expires,
        ?SameSiteEnum $sameSite
    ) {
        $this->path =  $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        $this->raw = $raw;
        $this->sameSite = $sameSite?->value;
        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires;
    }
}

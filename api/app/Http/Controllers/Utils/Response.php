<?php

use Illuminate\Http\JsonResponse;

enum SameSiteEnum: string
{
    case Lax = 'lax';
    case Strict = 'strict';
    case None = 'none';
}

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

enum JWTCookieTypeEnum: string
{
    case ACCESS_TOKEN = 'access_token';
    case REFRESH_TOKEN = 'refresh_token';
}

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

class Response
{
    public static function send(
        int $statusCode = 200,
        string $message = "Ok",
        mixed $data = null,
        ResponseStatusEnum $status = null,
        /** @var CookieOptions[] | JWTCookieOptions[] $cookies */
        array $cookies = []
    ): JsonResponse {
        if (!$status) {
            $status = $statusCode >= 200 && $statusCode < 300 ? 'success' : 'error';
        }

        $response = response();

        foreach ($cookies as $cookie) {
            if ($cookie instanceof CookieOptions) {
                $response->withCookie(
                    cookie(
                        $cookie->name,
                        $cookie->value,
                        $cookie->expires,
                        $cookie->path,
                        $cookie->domain,
                        $cookie->secure,
                        $cookie->httpOnly,
                        $cookie->raw,
                        $cookie->sameSite->value
                    )
                );
                continue;
            }
            throw new InvalidArgumentException('Invalid cookie type');
        }

        $resBody = new ControllerOutputData($message, $status, $data);
        return $response->json($resBody, $statusCode);
    }
}

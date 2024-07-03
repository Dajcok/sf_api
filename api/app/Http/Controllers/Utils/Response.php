<?php

namespace App\Http\Controllers\Utils;

use App\DTO\Output\ControllerOutputData;
use Cookie;
use Illuminate\Http\JsonResponse;
use App\Enums\ResponseStatusEnum;
use InvalidArgumentException;

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
            $status = $statusCode >= 200 && $statusCode < 300 ? ResponseStatusEnum::SUCCESS : ResponseStatusEnum::ERROR;
        }

        $response = new JsonResponse();

        foreach ($cookies as $cookie) {
            if ($cookie instanceof CookieOptions) {
                $response->withCookie(
                    Cookie::make(
                        $cookie->name,
                        $cookie->value,
                        $cookie->expires,
                        $cookie->path,
                        $cookie->domain,
                        $cookie->secure,
                        $cookie->httpOnly,
                        $cookie->raw ?? false,
                        $cookie->sameSite
                    )
                );
                continue;
            }
            throw new InvalidArgumentException('Invalid cookie type');
        }

        $resBody = new ControllerOutputData($message, $status, $data);
        $response->setStatusCode($statusCode);
        $response->setContent($resBody->jsonSerialize());
        return $response;
    }
}

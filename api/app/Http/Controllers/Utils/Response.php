<?php

namespace App\Http\Controllers\Utils;

use app\Contracts\DTO\ArrayableContract;
use app\DTO\Options\CookieOptions;
use app\DTO\Options\JWTCookieOptions;
use App\DTO\Output\ControllerOutputData;
use App\Enums\ResponseStatusEnum;
use Cookie;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

/**
 * Class Response
 * We use this class to send a response with a specific structure.
 *
 * @package App\Http\Controllers\Utils
 */
class Response
{
    public static function send(
        int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_OK,
        string $message = "Ok",
        array|ArrayableContract|null $data = null,
        ResponseStatusEnum $status = null,
        /** @var CookieOptions[] | JWTCookieOptions[] $cookies */
        array $cookies = [],
        array $errors = [],
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

        $data = $data instanceof ArrayableContract ? $data->toArray() : $data;
        $resBody = new ControllerOutputData($message, $status, $data, $errors);
        $response->setStatusCode($statusCode);
        $response->setContent($resBody->jsonSerialize());
        return $response;
    }
}

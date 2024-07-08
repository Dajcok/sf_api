<?php

namespace App\DTO\Output;

use app\Contracts\DTO\ArrayableContract;
use InvalidArgumentException;

/**
 * Class AuthenticatedOutputData that is used to return the authenticated user data from login and register endpoints
 *
 * @package App\DTO\Output
 *
 * @OA\Schema(
 *     schema="AuthenticatedOutputData",
 *     type="object",
 *     title="AuthenticatedOutputData",
 *     description="Authenticated user data",
 *     required={"accessToken", "refreshToken"},
 *     @OA\Property(property="access_token", type="string", description="Access token"),
 *     @OA\Property(property="refresh_token", type="string", description="Refresh token")
 * )
 */
class AuthenticatedOutputData implements ArrayableContract
{
    public string $accessToken;
    public string $refreshToken;

    public function __construct(string $accessToken, string $refreshToken)
    {
        if (empty($accessToken) || empty($refreshToken)) {
            throw new InvalidArgumentException('Access token and refresh token must not be empty');
        }

        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken
        ];
    }
}

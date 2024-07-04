<?php

namespace App\DTO\Output;

use JsonSerializable;

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
class AuthenticatedOutputData implements JsonSerializable
{
    public string $accessToken;
    public string $refreshToken;

    public function __construct(string $accessToken, string $refreshToken)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return json_encode([
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken
        ]);
    }
}

<?php

namespace App\DTO\Output;

/**
 * Class AuthenticatedOutputData that is used to return the authenticated user data from login and register endpoints
 * @package App\DTO\Output
 */
class AuthenticatedOutputData
{
    public string $accessToken;
    public string $refreshToken;

    public function __construct(string $accessToken, string $refreshToken)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }
}

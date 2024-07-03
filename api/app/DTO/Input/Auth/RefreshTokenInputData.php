<?php

namespace App\DTO\Input\Auth;

class RefreshTokenInputData
{
    public string $refreshToken;

    public function __construct(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }
}

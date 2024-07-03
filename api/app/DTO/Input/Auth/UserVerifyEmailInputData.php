<?php

namespace App\DTO\Input\Auth;

class UserVerifyEmailInputData
{
    public string $email;
    public string $token;

    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }
}

<?php

namespace App\DTO\Input\Auth;

class UserResetPasswordInputData
{
    public string $email;
    public string $token;
    public string $password;
    public string $passwordConfirmation;

    public function __construct(string $email, string $token, string $password, string $passwordConfirmation)
    {
        $this->email = $email;
        $this->token = $token;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }
}

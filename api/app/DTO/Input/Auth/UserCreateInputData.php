<?php

namespace App\DTO\Input\Auth;

class UserCreateInputData
{
    public string $name;
    public string $email;
    public string $password;
    public string $passwordConfirmation;

    public function __construct(string $name, string $email, string $password, string $passwordConfirmation)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }
}

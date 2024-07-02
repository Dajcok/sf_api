<?php

namespace App\DTO\Input;

class UserCreateInputData
{
    public string $name;
    public string $email;
    public string $password;
    public string $password_confirmation;

    public function __construct(string $name, string $email, string $password, string $password_confirmation)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }
}

class UserUpdateInputData
{
    public string $name;
    public string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
}

class UserLoginInputData
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}

class UserChangePasswordInputData
{
    public string $old_password;
    public string $new_password;
    public string $new_password_confirmation;

    public function __construct(string $old_password, string $new_password, string $new_password_confirmation)
    {
        $this->old_password = $old_password;
        $this->new_password = $new_password;
        $this->new_password_confirmation = $new_password_confirmation;
    }
}


class UserResetPasswordInputData
{
    public string $email;
    public string $token;
    public string $password;
    public string $password_confirmation;

    public function __construct(string $email, string $token, string $password, string $password_confirmation)
    {
        $this->email = $email;
        $this->token = $token;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }
}

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

class AuthTokenInputData
{
    public string $email;
    public string $id;

    public function __construct(string $email, string $id)
    {
        $this->email = $email;
        $this->id = $id;
    }
}

abstract class UserMetaInfo
{
    public string $email;
    public string $id;

    public function __construct(string $email, string $id)
    {
        $this->email = $email;
        $this->id = $id;
    }
}

abstract class AuthenticatedData
{
    public UserMetaInfo $usr;

    public function __construct(UserMetaInfo $usr)
    {
        $this->usr = $usr;
    }
}

class RefreshTokenInputData extends AuthenticatedData
{
    public string $refreshToken;

    public function __construct(string $refreshToken, UserMetaInfo $usr)
    {
        parent::__construct($usr);
        $this->refreshToken = $refreshToken;
    }
}

<?php

namespace App\DTO\Input\Auth;

class UserChangePasswordInputData
{
    public string $old_password;
    public string $newPassword;
    public string $newPasswordConfirmation;

    public function __construct(string $old_password, string $newPassword, string $newPasswordConfirmation)
    {
        $this->old_password = $old_password;
        $this->newPassword = $newPassword;
        $this->newPasswordConfirmation = $newPasswordConfirmation;
    }
}

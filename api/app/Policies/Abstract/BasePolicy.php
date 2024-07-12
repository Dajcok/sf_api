<?php

namespace App\Policies\Abstract;

use App\Models\User;

abstract class BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    protected function isAdmin(User $user): bool
    {
        return $user->is_admin;
    }
}

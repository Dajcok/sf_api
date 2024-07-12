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

    /**
     * Base method to determine whether the user can view the model.
     * It has priority over the logic in view method.
     */
    protected function isAdmin(User $user): bool
    {
        return $user->is_admin;
    }
}

<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use App\Policies\Abstract\BasePolicy;

class RestaurantPolicy extends BasePolicy
{
    private function isOwner(User $user, Restaurant $restaurant): bool
    {
        return $user->restaurant_id === $restaurant->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restaurant $restaurant): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $restaurant);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restaurant $restaurant): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $restaurant);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $this->isAdmin($user);
    }
}

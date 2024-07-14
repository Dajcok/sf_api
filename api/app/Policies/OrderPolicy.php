<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\Order;
use App\Models\User;
use App\Policies\Abstract\BasePolicy;

class OrderPolicy extends BasePolicy
{
    private function isOwner(User $user, Order $order): bool
    {
        if ($user->role === UserRoleEnum::RESTAURANT_STAFF->value) {
            return $user->restaurant_id === $order->restaurant_id;
        }

        return $user->id === $order->created_by;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $order);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRoleEnum::CUSTOMER->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $order);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $order);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $this->isAdmin($user);
    }
}

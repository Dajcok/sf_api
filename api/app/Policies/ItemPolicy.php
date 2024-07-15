<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\User;
use App\Policies\Abstract\BasePolicy;

class ItemPolicy extends BasePolicy
{
    private function isOwner(User $user, Item|StoreItemRequest $item): bool
    {
        return $user->role === UserRoleEnum::RESTAURANT_STAFF->value && $item->restaurant_id === $user->restaurant_id;
    }

    public function viewAny(User $user): bool
    {
        //We want to allow all users to view any items
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        //We want to allow all users to view items
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $user->role === UserRoleEnum::RESTAURANT_STAFF->value && $user->restaurant_id === request()->all()['restaurant_id'];
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Item $item): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $item);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Item $item): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $item);
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

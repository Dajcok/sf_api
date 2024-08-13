<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Policies\Abstract\BasePolicy;
use App\Models\User;

class CategoryPolicy extends BasePolicy
{
    private function isOwner(User $user, Category|StoreCategoryRequest $category): bool
    {
        return $user->role === UserRoleEnum::RESTAURANT_STAFF->value && $category->restaurant_id === $user->restaurant_id;
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

        return $user->role === UserRoleEnum::RESTAURANT_STAFF->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $category);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $category);
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

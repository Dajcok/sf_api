<?php

namespace App\Policies;

use App\Http\Requests\StoreTableRequest;
use App\Models\Table;
use App\Models\User;
use App\Policies\Abstract\BasePolicy;

class TablePolicy extends BasePolicy
{
    private function isOwner(User $user, Table|StoreTableRequest $table): bool
    {
        return $user->role === 'RESTAURANT_STAFF' && $user->restaurant_id === $table->restaurant_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Table $table): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $table);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, StoreTableRequest $table): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $table);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Table $table): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $table);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Table $table): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $this->isOwner($user, $table);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Table $table): bool
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

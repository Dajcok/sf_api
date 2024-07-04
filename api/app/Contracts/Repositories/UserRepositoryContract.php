<?php

namespace app\Contracts\Repositories;

use App\Models\User;

/**
 * Interface UserRepositoryContract
 * @extends RepositoryContract<User>
 */
interface UserRepositoryContract extends RepositoryContract
{
    public function create(array $data): User;
    public function update(int $id, array $data): User;
    public function find(int $id): User;
}

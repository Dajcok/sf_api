<?php

namespace app\Contracts\Repositories;

use App\Models\User;

/**
 * Interface UserRepositoryContract
 * @extends RepositoryContract<User>
 */
interface UserRepositoryContract extends RepositoryContract
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(int $id, array $data): User;

    /**
     * @param int $id
     * @return User
     */
    public function find(int $id): User;
}

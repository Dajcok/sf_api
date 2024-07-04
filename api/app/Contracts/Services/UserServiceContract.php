<?php

namespace App\Contracts\Services;

use App\Contracts\Services\Abstract\CrudServiceContract;
use App\Models\User;

/**
 * UserServiceContract interface
 * We need to specify this interface to make sure that the UserService class
 * has correct return types for the methods. In this case, we are specifying
 * that the UserService class should have the correct return types for the
 * create, update, and find methods - User.
 *
 * @extends CrudServiceContract<User>
 * @package App\Contracts\Services
 */
interface UserServiceContract extends CrudServiceContract
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

<?php

namespace App\Services;

use app\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Models\User;
use App\Services\Base\CrudService;

/**
 * @extends CrudService<User, UserRepositoryContract>
 */
class UserService extends CrudService implements UserServiceContract
{
    /**
     * @param UserRepositoryContract $repository
     */
    public function __construct(UserRepositoryContract $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return parent::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(int $id, array $data): User
    {
        return parent::update($id, $data);
    }

    /**
     * @param int $id
     * @return User
     */
    public function find(int $id): User
    {
        return parent::find($id);
    }
}

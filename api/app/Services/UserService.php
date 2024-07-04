<?php

namespace App\Services;

use app\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Models\User;
use App\Services\Base\CrudService;

/**
 * {@inheritdoc}
 */
class UserService extends CrudService implements UserServiceContract
{
    /**
     * {@inheritdoc}
     */
    public function __construct(UserRepositoryContract $repository)
    {
        parent::__construct($repository);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data): User
    {
        return parent::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): User
    {
        return parent::update($id, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $id): User
    {
        return parent::find($id);
    }
}

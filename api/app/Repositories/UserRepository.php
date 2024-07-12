<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 * @extends Repository<User>
 */
class UserRepository extends Repository implements UserRepositoryContract
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model) ;
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

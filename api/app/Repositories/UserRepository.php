<?php

namespace App\Repositories;

use app\Contracts\Repositories\UserRepositoryContract;
use App\Models\User;

class UserRepository extends Repository implements UserRepositoryContract
{
    public function __construct(User $model)
    {
        parent::__construct($model) ;
    }
}

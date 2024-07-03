<?php

namespace App\Services;

use App\Contracts\Services\UserServiceContract;
use App\Models\User;
use App\Services\Base\CrudService;

class UserService extends CrudService implements UserServiceContract
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}

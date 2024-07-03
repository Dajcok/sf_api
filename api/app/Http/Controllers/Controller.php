<?php

namespace App\Http\Controllers;

use app\Contracts\Services\AuthServiceContract;

abstract class Controller
{
    protected AuthServiceContract $service;

    public function __construct(mixed $service)
    {
        $this->service = $service;
    }
}

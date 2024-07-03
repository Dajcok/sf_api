<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected mixed $service;

    public function __construct(mixed $service)
    {
        $this->service = $service;
    }
}

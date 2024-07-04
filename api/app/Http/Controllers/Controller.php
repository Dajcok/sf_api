<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="SwiftFeast REST API.",
 *     version="1.0",
 *     description="This API is powered by Laravel 11. It is a RESTful API with JWT authentication.",
 * )
 *
 * @OA\Schema(
 *     schema="ApiResponse",
 *     type="object",
 *     title="ApiResponse",
 *     @OA\Property(property="message", type="string"),
 *     @OA\Property(property="status", type="string"),
 * )
 */
abstract class Controller
{
    protected mixed $service;

    public function __construct(mixed $service)
    {
        $this->service = $service;
    }
}

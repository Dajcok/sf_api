<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\Response;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    /**
     * Get the authenticated user.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = $this->service->find(auth()->id())->toArray();

        return Response::send(data: $user);
    }
}

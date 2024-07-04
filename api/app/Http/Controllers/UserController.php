<?php

namespace App\Http\Controllers;

use App\DTO\Output\UserOutputData;
use App\Http\Controllers\Utils\Response;
use App\Services\UserService;
use Auth;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="User",
 *     description="Endpoints for user management"
 * )
 */
class UserController extends Controller
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    /**
     * @OA\Get(
     *     path="/api/user/me/",
     *     tags={"User"},
     *     @OA\Response(
     *         response="200",
     *         description="Get the authenticated user",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/User")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function me(): JsonResponse
    {
        $user = Auth::user();
        $responseData = new UserOutputData(...$user);

        return Response::send(data: $responseData);
    }
}

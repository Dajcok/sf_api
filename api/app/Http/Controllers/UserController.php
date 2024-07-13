<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Abstract\Controller;
use App\Http\Controllers\Utils\Response;
use App\Http\Resources\UserResource;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="User",
 *     description="Endpoints for user management"
 * )
 */
class UserController extends Controller
{
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
    public function me(Request $request): JsonResponse
    {
        $responseData = new UserResource($request->user());
        return Response::send(data: $responseData->toArray());
    }
}

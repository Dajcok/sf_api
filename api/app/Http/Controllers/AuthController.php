<?php

namespace App\Http\Controllers;

use app\Contracts\Services\AuthServiceContract;
use App\DTO\Output\AuthenticatedOutputData;
use App\Enums\JWTCookieTypeEnum;
use App\Exceptions\Api\Unauthorized;
use App\Http\Controllers\Utils\JWTCookieOptions;
use App\Http\Controllers\Utils\Response;
use app\Http\Requests\Auth\RefreshTokenRequest;
use app\Http\Requests\Auth\UserCreateRequest;
use app\Http\Requests\Auth\UserLoginRequest;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Endpoints for authentication"
 * )
 */
class AuthController extends Controller
{
    protected mixed $service;

    public function __construct(AuthServiceContract $authService)
    {
        parent::__construct($authService);
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/api/auth/register/",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="password_confirmation", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Registered successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/AuthenticatedOutputData")
     *                 )
     *             }
     *        )
     *     ),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function register(UserCreateRequest $request): JsonResponse
    {
        $validatedData = $request->toUserCreateInputData();
        $tokens = $this->service->register($validatedData);

        return Response::send(
            statusCode: 201,
            message: 'Registered successfully',
            data: new AuthenticatedOutputData(accessToken: $tokens->accessToken, refreshToken: $tokens->refreshToken),
            cookies: [
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::ACCESS_TOKEN,
                    value: $tokens->accessToken,
                ),
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::REFRESH_TOKEN,
                    value: $tokens->refreshToken,
                ),
            ]
        );
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login/",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Logged in successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/AuthenticatedOutputData")
     *                 )
     *             }
     *        )
     *     ),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $validatedData = $request->toUserLoginInputData();
        $tokens = $this->service->login($validatedData);

        return Response::send(
            message: 'Logged in successfully',
            data: new AuthenticatedOutputData(accessToken: $tokens->accessToken, refreshToken: $tokens->refreshToken),
            cookies: [
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::ACCESS_TOKEN,
                    value: $tokens->accessToken,
                ),
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::REFRESH_TOKEN,
                    value: $tokens->refreshToken,
                ),
            ]
        );
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh-token/",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/AuthenticatedOutputData")
     *                 )
     *             }
     *        )
     *     ),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $validatedData = $request->toRefreshTokenInputData();
        $tokens = $this->service->refreshToken($validatedData);

        return Response::send(
            message: 'Token refreshed successfully',
            data: new AuthenticatedOutputData(accessToken: $tokens->accessToken, refreshToken: $tokens->refreshToken),
            cookies: [
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::ACCESS_TOKEN,
                    value: $tokens->accessToken,
                ),
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::REFRESH_TOKEN,
                    value: $tokens->refreshToken,
                ),
            ]
        );
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout/",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response="200",
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *             }
     *        )
     *     ),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function logout(): JsonResponse
    {
        $this->service->logout();

        return Response::send(
            message: 'Logged out successfully',
            cookies: [
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::ACCESS_TOKEN,
                    value: '',
                ),
                new JWTCookieOptions(
                    type: JWTCookieTypeEnum::REFRESH_TOKEN,
                    value: '',
                ),
            ]
        );
    }
}

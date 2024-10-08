<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceContract;
use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Options\JWTCookieOptions;
use App\DTO\Output\AuthenticatedOutputData;
use App\Enums\JWTCookieTypeEnum;
use App\Exceptions\Api\Unauthorized;
use App\Http\Controllers\Abstract\Controller;
use App\Http\Controllers\Utils\Response;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Endpoints for authentication"
 * )
 */
class AuthController extends Controller
{
    public function __construct(protected AuthServiceContract $service)
    {
        parent::__construct();
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
     * @throws QueryException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->toUserCreateInputData();
        $tokens = $this->service->register($validatedData);

        return Response::send(
            statusCode: \Symfony\Component\HttpFoundation\Response::HTTP_CREATED,
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
     * @throws Unauthorized
     */
    public function login(LoginRequest $request): JsonResponse
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
     *     path="/api/auth/refresh/",
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
     * @throws Unauthorized
     */
    public function refreshToken(): JsonResponse
    {
        if (!isset($_COOKIE[config('jwt.cookie.refresh_token_name', 'refresh_token')])) {
            throw new Unauthorized('Refresh token not found');
        }

        $tokens = $this->service->refreshToken(new RefreshTokenInputData($_COOKIE[config('jwt.cookie.refresh_token_name', 'refresh_token')]));

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
        $refresh = $_COOKIE[config('jwt.cookie.refresh_token_name', 'refresh_token')];

        if($refresh) {
            $this->service->removeRefreshToken($refresh);
        }

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

    /**
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/auth/customer/",
     *     description="Creates a new user with role customer and is_anonymus = true",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response="200",
     *         description="Customer created successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/AuthenticatedOutputData")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function createCustomer(): JsonResponse
    {
        $tokens = $this->service->createCustomer();

        return Response::send(
            statusCode: \Symfony\Component\HttpFoundation\Response::HTTP_CREATED,
            message: 'Customer created successfully',
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
}

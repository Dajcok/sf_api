<?php

namespace App\Http\Controllers;

use app\Contracts\Services\AuthServiceContract;
use App\DTO\Output\AuthenticatedOutputData;
use App\Enums\JWTCookieTypeEnum;
use App\Exceptions\Api\Unauthorized;
use App\Http\Controllers\Utils\JWTCookieOptions;
use App\Http\Controllers\Utils\Response;
use app\Http\Requests\Auth\UserCreateRequest;
use app\Http\Requests\Auth\UserLoginRequest;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected mixed $service;

    public function __construct(AuthServiceContract $authService)
    {
        parent::__construct($authService);
    }

    /**
     * @param UserCreateRequest $request
     * @return JsonResponse
     * @throws QueryException
     */
    public function register(UserCreateRequest $request): JsonResponse
    {
        $validatedData = $request->toUserCreateInputData();
        $tokens = $this->service->register($validatedData);

        /**
         * @var AuthenticatedOutputData $data
         */
        return Response::send(
            statusCode: 201,
            message: 'User created',
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
     * @param UserLoginRequest $request
     * @return JsonResponse
     * @throws Unauthorized
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $validatedData = $request->toUserLoginInputData();
        $tokens = $this->service->login($validatedData);

        /**
         * @var AuthenticatedOutputData $data
         */
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

    public function me(): JsonResponse
    {
        return response()->json(Auth::user());
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}

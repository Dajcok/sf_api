<?php

namespace App\Http\Controllers;

use App\DTO\Output\AuthenticatedOutputData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use JWTCookieOptions;
use JWTCookieTypeEnum;
use Response;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $tokens = $this->service->register($request->all());

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

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
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

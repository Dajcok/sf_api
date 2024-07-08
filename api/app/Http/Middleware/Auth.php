<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Authenticate the user by the token.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws JWTException
     */
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->cookie(config('jwt.cookie.access_token_name'));

        // Unfortunatelly I cannot get the token from the cookie when testing,
        // because withCookie() method is not working in the tests.
        // I did this as a temporary solution.
        // In production the cookie is working fine.
        if(!$accessToken) {
            $accessToken = $request->bearerToken();
        }

        if (!$accessToken) {
            throw new JWTException();
        }

        JWTAuth::setToken($accessToken);
        JWTAuth::authenticate();

        return $next($request);
    }
}

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
        //Exception handling is done in the Handler.php

        $accessToken = $request->cookie(config('jwt.cookie.access_token_name'));
        if (!$accessToken) {
            throw new JWTException();
        }

        JWTAuth::setToken($accessToken);
        JWTAuth::authenticate();

        return $next($request);
    }
}

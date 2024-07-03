<?php

namespace App\Http\Middleware;

use App\Exceptions\Api\NotAcceptable;
use App\Exceptions\Api\UnsupportedMediaType;
use Closure;
use Illuminate\Http\Request;

class EnforceHeaders
{
    /**
     * Check if the Content-Type header is set to application/json and
     * Accept header is set to application/json.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws UnsupportedMediaType
     * @throws NotAcceptable
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->headers->has('Content-Type') || $request->header('Content-Type') !== 'application/json') {
            throw new UnsupportedMediaType('Content-Type header missing or incorrect');
        }

        if (!$request->headers->has('Accept') || $request->header('Accept') !== 'application/json') {
            throw new NotAcceptable('Accept header missing or incorrect');
        }

        return $next($request);
    }
}

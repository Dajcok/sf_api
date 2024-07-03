<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResponseLogger
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if ($response->isClientError() || $response->isServerError()) {
            $statusCode = $response->getStatusCode();
            $method = $request->getMethod();
            $url = $request->fullUrl();
            $errorMessage = $response->getContent();

            Log::error("HTTP $statusCode Error: $method $url - $errorMessage");
        }

        return $response;
    }
}

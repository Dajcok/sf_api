<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('Incoming Request', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'uri' => $request->getRequestUri(),
            'method' => $request->getMethod(),
        ]);

        return $next($request);
    }
}

<?php

use App\Exceptions\Api\ApiError;
use App\Exceptions\Api\BadRequest;
use App\Exceptions\Api\InternalError;
use App\Exceptions\Api\NotFound;
use App\Exceptions\Api\Unauthorized;
use App\Http\Middleware\ResponseLogger;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Psr\Log\LogLevel;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Controllers\Utils\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ResponseLogger::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //This will ensure that duplicate exceptions are not reported
        $exceptions->dontReportDuplicates();
        $exceptions->level(ApiError::class, LogLevel::ERROR);
        $exceptions->render(function (Request $request, Exception $e) {
            //Caught exceptions from upper layers and converted to ApiError
            if ($e instanceof ApiError) {
                return Response::send($e->getCode(), $e->getMessage());
            }
            //--------------------------------JWT exceptions--------------------------------
            //Token not provided
            if ($e instanceof JWTException) {
                //General
                $msg = 'Token not provided';

                //Token expired
                if ($e instanceof TokenExpiredException) {
                    $msg = 'Token expired';
                } //Token invalid
                elseif ($e instanceof TokenInvalidException) {
                    $msg = 'Token invalid';
                }

                $unauthorizedExcp = new Unauthorized($msg);
                return Response::send($unauthorizedExcp->getCode(), $unauthorizedExcp->getMessage());
            }
            //-------------------------------Model exceptions-------------------------------
            //Not found
            if ($e instanceof ModelNotFoundException) {
                $notFoundExcp = new NotFound(
                    `Model not found: {${$e->getModel()}} with id: {${$e->getIds()}}`
                );
                return Response::send($notFoundExcp->getCode(), $notFoundExcp->getMessage());
            }
            //Unique constraint violation
            if ($e instanceof QueryException) {
                if ($e->errorInfo[1] == 1062) {
                    $badRequestExcp = new BadRequest('Unique constraint violation');
                    return Response::send($badRequestExcp->getCode(), $badRequestExcp->getMessage());
                }
            }
            //Uncaught exceptions from upper layers
            $internalServerErrorExcp = new InternalError('Internal Server Error');
            return Response::send($internalServerErrorExcp->getCode(), $internalServerErrorExcp->getMessage());
        });

        //TODO: Add more exception handlers here
    })->create();

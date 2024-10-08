<?php


use App\Exceptions\Api\ApiError;
use App\Exceptions\Api\BadRequest;
use App\Exceptions\Api\InternalError;
use App\Exceptions\Api\NotFound;
use App\Exceptions\Api\Unauthorized;
use App\Exceptions\Api\UnprocessableContent;
use Illuminate\Auth\Access\AuthorizationException;
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
use \Symfony\Component\HttpFoundation\Response as SymfonyResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->throttleWithRedis();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //This will ensure that duplicate exceptions are not reported
        $exceptions->dontReportDuplicates();
        //We want to report all exceptions
        $exceptions->level(Throwable::class, LogLevel::ERROR);

        $exceptions->render(function (ApiError $e) {
            if ($e instanceof UnprocessableContent) {
                return Response::send(statusCode: $e->getCode(), message: $e->getMessage(), errors: $e->getErrors());
            }

            return Response::send(statusCode: $e->getCode(), message: $e->getMessage());
        });
        $exceptions->render(function (JWTException $e) {
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
        });
        $exceptions->render(function (ModelNotFoundException $e) {
            $notFoundExcp = new NotFound(
                `{${$e->getModel()}} with id: {${$e->getIds()}} not found`
            );

            return Response::send($notFoundExcp->getCode(), $notFoundExcp->getMessage());
        });
        $exceptions->render(function (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $badRequestExcp = new BadRequest('Unique constraint violation');
                return Response::send($badRequestExcp->getCode(), $badRequestExcp->getMessage());
            }

            $internalErrorExcp = new InternalError('Database error');

            return Response::send($internalErrorExcp->getCode(), $internalErrorExcp->getMessage());
        });

        $exceptions->render(function (AuthorizationException $e) {
            return Response::send(SymfonyResponse::HTTP_FORBIDDEN, 'Verify your permissions.');
        });

        $exceptions->report(function (Throwable $e) {
            //Report to Sentry
        });
    })->create();

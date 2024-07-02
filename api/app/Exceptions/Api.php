<?php

namespace App\Exceptions\Api;

use Exception;

class ApiError extends Exception
{
    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

//500
class InternalError extends ApiError
{
    public function __construct(string $message = 'Internal error', int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

//400
class BadRequest extends ApiError
{
    public function __construct(string $message = 'Bad request', int $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

//401
class Unauthorized extends ApiError
{
    public function __construct(string $message = 'Unauthorized', int $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

//403
class Forbidden extends ApiError
{
    public function __construct(string $message = 'Forbidden', int $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

//404
class NotFound extends ApiError
{
    public function __construct(string $message = 'Not found', int $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

//422
class UnprocessableEntity extends ApiError
{
    public function __construct(string $message = 'Unprocessable entity', int $code = 422, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

<?php

namespace App\Exceptions\Api;

//500
use Exception;

class InternalError extends ApiError
{
    public function __construct(string $message = 'Internal error', int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

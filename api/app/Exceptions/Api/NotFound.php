<?php

namespace App\Exceptions\Api;

//404
use Exception;

class NotFound extends ApiError
{
    public function __construct(string $message = 'Not found', int $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

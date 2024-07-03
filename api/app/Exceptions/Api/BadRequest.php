<?php

namespace App\Exceptions\Api;

use Exception;

class BadRequest extends ApiError
{
    public function __construct(string $message = 'Bad request', int $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

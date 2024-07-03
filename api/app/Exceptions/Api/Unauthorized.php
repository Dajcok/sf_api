<?php

namespace App\Exceptions\Api;

//401
use Exception;

class Unauthorized extends ApiError
{
    public function __construct(string $message = 'Unauthorized', int $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

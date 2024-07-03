<?php

namespace App\Exceptions\Api;

//403
use Exception;

class Forbidden extends ApiError
{
    public function __construct(string $message = 'Forbidden', int $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

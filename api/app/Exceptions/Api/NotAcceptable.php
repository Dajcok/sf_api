<?php

namespace App\Exceptions\Api;

//406
use Exception;

class NotAcceptable extends ApiError
{
    public function __construct(string $message = 'Not acceptable', int $code = 406, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

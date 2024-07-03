<?php

namespace App\Exceptions\Api;

//415
use Exception;

class UnsupportedMediaType extends ApiError
{
    public function __construct(string $message = 'Unsupported media type', int $code = 415, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

<?php

namespace App\Exceptions\Api;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UnprocessableContent extends ApiError
{
    public array $errors;

    public function __construct(string $message = 'Unprocessable content', int $code = Response::HTTP_UNPROCESSABLE_ENTITY, array $errors = [], Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

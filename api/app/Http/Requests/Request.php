<?php

namespace App\Http\Requests;

use App\Exceptions\Api\UnprocessableContent;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * @throws UnprocessableContent
     */
    protected function failedValidation(Validator $validator)
    {
        throw new UnprocessableContent(
            message: 'Request failed with validation error. Check \'errors\' for details.',
            errors: $validator->errors()->toArray()
        );
    }
}

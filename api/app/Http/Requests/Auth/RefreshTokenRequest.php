<?php

namespace App\Http\Requests\Auth;

use App\DTO\Input\Auth\RefreshTokenInputData;
use Illuminate\Foundation\Http\FormRequest;

class RefreshTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }

    public function toRefreshTokenInputData(): RefreshTokenInputData
    {
        return new RefreshTokenInputData(
            $this->input('refresh_token')
        );
    }
}

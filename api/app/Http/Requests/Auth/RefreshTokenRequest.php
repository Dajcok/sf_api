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
        $data = $this->validated();

        return new RefreshTokenInputData(
            $data['refresh_token'],
        );
    }
}

<?php

namespace App\Http\Requests\Auth;

use App\DTO\Input\Auth\UserLoginInputData;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function toUserLoginInputData(): UserLoginInputData
    {
        $data = $this->validated();

        return new UserLoginInputData(
            $data['email'],
            $data['password'],
        );
    }
}

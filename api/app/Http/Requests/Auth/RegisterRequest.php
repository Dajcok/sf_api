<?php

namespace App\Http\Requests\Auth;

use App\DTO\Input\Auth\UserCreateInputData;
use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function toUserCreateInputData(): UserCreateInputData
    {
        $data = $this->validated();

        return new UserCreateInputData(
            $data['name'],
            $data['email'],
            $data['password'],
        );
    }
}

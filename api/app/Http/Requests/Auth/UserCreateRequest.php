<?php

namespace app\Http\Requests\Auth;

use App\DTO\Input\Auth\UserCreateInputData;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
        return new UserCreateInputData(
            $this->input('name'),
            $this->input('email'),
            $this->input('password'),
        );
    }
}

<?php

namespace App\Http\Requests;

use App\DTO\Input\Auth\UserCreateInputData;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password1' => 'required|string|min:8|confirmed',
            'password2' => 'required|string|min:8',
        ];
    }

    public function toUserCreateInputData(): UserCreateInputData
    {
        return new UserCreateInputData(
            $this->input('name'),
            $this->input('email'),
            $this->input('password1'),
            $this->input('password2')
        );
    }
}

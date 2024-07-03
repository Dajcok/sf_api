<?php

namespace app\Http\Requests\Auth;

use App\DTO\Input\Auth\UserLoginInputData;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function toUserLoginInputData(): UserLoginInputData
    {
        return new UserLoginInputData(
            $this->input('email'),
            $this->input('password')
        );
    }
}

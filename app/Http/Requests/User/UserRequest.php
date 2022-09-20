<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();

    }

    public function rules(): array
    {


        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user?->id,
            'password' => 'required',
            'roles' => 'required',
        ];
    }
}

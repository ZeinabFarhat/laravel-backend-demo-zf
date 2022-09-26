<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;


class RoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();

    }

    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}

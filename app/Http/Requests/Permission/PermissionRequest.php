<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PermissionRequest extends FormRequest
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

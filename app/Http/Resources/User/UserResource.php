<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role\RoleResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'roles' => RoleResource::collection($this->whenLoaded('roles'))
        ];

    }
}

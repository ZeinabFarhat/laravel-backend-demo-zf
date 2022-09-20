<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\Users\User;
use App\Helpers\Minion;
use Spatie\Permission\Models\Role;
use App\Http\Requests\User\UserRequest;

class UserService
{
    public function createUser(UserRequest $request): User
    {
        $roles_ids = [];
        $selected_roles = json_decode($request->get('roles'));

        foreach ($selected_roles as $id => $value) {
            $roles_ids[] = $value->id;

        }

        $selectedRoles = Role::whereIn('id', $roles_ids)->pluck('name');

        $user = User::create(
            [
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'slug' => $request->get('first_name') . '-' . $request->get('last_name')
            ]
        );

        $user->syncRoles($selectedRoles);
        return $user;
    }

    public function updateUser(UserRequest $request, User $user): User
    {
        $roles_ids = [];
        $selected_roles = json_decode($request->get('roles'));

        foreach ($selected_roles as $id => $value) {

            array_push($roles_ids, $value->id);

        }

        $selectedRoles = Role::whereIn('id', $roles_ids)->pluck('name');
        $user->update($request->only(['first_name', 'last_name', 'email']));

        if ($request->has('password')) {
            $user->password = $request->get('password');
        }

        $user->slug = Minion::create_slug($request->get('first_name') . $request->get('last_name'), User::class);
        $user->save();

        $user->syncRoles($selectedRoles);

        return $user;
    }
}
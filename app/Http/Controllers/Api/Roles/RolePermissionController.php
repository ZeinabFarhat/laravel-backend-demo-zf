<?php

namespace App\Http\Controllers\Api\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolePermissionController extends Controller
{
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        $permissions_ids = [];

        if ($role) {

            if ($request->has('permissions')) {

                $permissions_checked = json_decode($request->get('permissions'));

                foreach ($permissions_checked as $id => $value) {

                    array_push($permissions_ids, $value->id);

                }

                $permissions = Permission::whereIn('id', $permissions_ids)->get();
                $role->syncPermissions($permissions);

            } else {
                $permissions = Permission::all();

                foreach ($permissions as $permission) {
                    $role->revokePermissionTo($permission->name);
                }
            }

            return $role;

        } else {
            return abort(404);
        }
    }
}


<?php namespace App\Services;

use App\Http\Requests\Permission\PermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function createPermission(PermissionRequest $request): Permission
    {
            $permission = new Permission();
            $permission->name = $request->get('name');
            $permission->guard_name= 'web';
            $permission->save();

            return $permission;
    }

     public function updatePermission(PermissionRequest $request, Permission $permission): Permission
        {
              $name = $request->get( 'name' );
              $permission->name = $name;
              $permission->save();

              return $permission;
        }
}
<?php namespace App\Services;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function createPermission(Request $request): Permission
    {
            $permission = new Permission();
            $permission->name = $request->get('name');
            $permission->guard_name= 'web';
            $permission->save();

            return $permission;
    }

     public function updatePermission(Request $request): Permission
        {
              $name = $request->get( 'name' );
              $permission->name = $name;
              $permission->save();

              return $permission;
        }
}
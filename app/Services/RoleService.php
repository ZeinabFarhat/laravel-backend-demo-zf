<?php
namespace App\Services;

use Spatie\Permission\Models\Role;
use App\Http\Requests\Role\RoleRequest;

class RoleService
{

    public function createRole(RoleRequest $request): Role

    {
                $role = Role::create(
                    [
                        'name'     => $request->get( 'name' ),
                        'guard_name'    => 'web',

                    ]
                );

                return $role;
    }

    public function updateRole(RoleRequest $request,Role $role ) :Role{

        $role->update( $request->only( [ 'name' ] ) );

        return $role;
    }
}
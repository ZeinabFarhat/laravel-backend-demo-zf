<?php

namespace App\Http\Controllers\Api\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Models\Roles\Role;
use App\Http\Resources\Role\RoleResource;
use App\Services\RoleService;
use  App\Http\Requests\Role\RoleRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $roles = Role::orderby('created_at', 'DESC')->paginate(1);
        View::share('page_title', 'Roles');

        return RoleResource::collection($roles);

    }

    public function store(RoleRequest $request, RoleService $roleService): RoleResource
    {
        $role = $roleService->createRole($request);
        return new RoleResource($role);
    }

    public function show(Role $role): RoleResource
    {
        View::share('page_title', 'Role [ ' . $role->name . ' ] | Edit');
        return RoleResource::make(Role::with(['permissions'])->find($role->id));
    }

    function update(RoleRequest $request, Role $role, RoleService $roleService): RoleResource
    {
        $role = $roleService->updateRole($request, $role);

        return new RoleResource($role);
    }

    public function destroy(Role $role): ?bool
    {
        return $role->delete();
    }

    public function getAllRoles(): AnonymousResourceCollection
    {
        $roles = Role::all();
        return RoleResource::collection($roles);
    }
}

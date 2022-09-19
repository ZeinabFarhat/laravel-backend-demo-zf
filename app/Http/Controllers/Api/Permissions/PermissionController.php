<?php

namespace App\Http\Controllers\Api\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permission\PermissionRequest;
use App\Services\PermissionService;
use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class PermissionController extends Controller
{

    public function index(): AnonymousResourceCollection
    {

        $permissions = Permission::orderby('created_at', 'DESC')->paginate(1);
        View::share('page_title', 'Permissions');

        return PermissionResource::collection($permissions);
    }


    public function store(PermissionRequest $request, PermissionService $permissionService): PermissionResource
    {

        $permission = $permissionService->createPermission($request);
        return new PermissionResource($permission);
    }


    public function show(Permission $permission): PermissionResource
    {
        return PermissionResource::make(Permission::find($permission->id));
    }


    public function update(PermissionRequest $request, Permission $permission): PermissionResource
    {

        $name = $request->get('name');

        $permission->name = $name;
        $permission->save();

        return new PermissionResource($permission);
    }


    public function destroy(Permission $permission): ?bool
    {

        return $permission->delete();

    }


    public function getAllPermissions(): AnonymousResourceCollection
    {

        $permissions = Permission::all();

        return PermissionResource::collection($permissions);
    }
}

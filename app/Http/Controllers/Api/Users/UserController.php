<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\View;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        View::share('page_title', 'Users');
        $users = User::with(['roles'])->orderby('created_at', 'DESC')->paginate(1);
        return UserResource::collection($users);
    }

    public function store(UserRequest $request, UserService $userService): UserResource
    {
        $user = $userService->createUser($request);
        return new UserResource($user);
    }

    public function show(User $user): UserResource
    {
        return UserResource::make(User::with(['roles'])->find($user->id));
    }

    public function update(UserRequest $request, User $user, UserService $userService): UserResource
    {
        $user = $userService->updateUser($request, $user);

        return new UserResource($user);
    }

    public function destroy(User $user): ?bool
    {
        return $user->delete();
    }
}

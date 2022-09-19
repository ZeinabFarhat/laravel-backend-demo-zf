<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Permissions\PermissionController;
use  App\Http\Controllers\Api\Roles\RoleController;
use App\Http\Controllers\Api\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::get('roles/get_all_roles', [RoleController::class, 'getallRoles']);
Route::get('permissions/get_all_permissions', [PermissionController::class, 'getAllPermissions']);
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/roles', RoleController::class);
    Route::prefix('role')->group(function () {
        Route::resource('permission', 'Roles\RolePermissionController');
    });
});


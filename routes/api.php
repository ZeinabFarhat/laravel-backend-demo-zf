<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Permissions\PermissionController;
use  App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;

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
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

 Route::get('roles/get_all_roles', [RoleController::class, 'get_all_roles']);
 Route::get('permissions/get_all_permissions', [PermissionController::class, 'get_all_permissions']);
Route::middleware('auth:sanctum')->group(function () {
 Route::resource('users', UserController::class);
 Route::resource('/permissions', PermissionController::class);
 Route::resource('/roles', RoleController::class);
 Route::prefix('role')->group(function () {
              Route::resource('permission', 'Roles\RolePermissionController');
          });
});


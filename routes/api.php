<?php

use App\Http\Controllers\V1\Admin\CategoryController;
use App\Http\Controllers\V1\Admin\RoleController;
use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // roles
    Route::get('/get-roles', [RoleController::class, 'getRoles']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //categories
    Route::apiResource('/categories', CategoryController::class);
});

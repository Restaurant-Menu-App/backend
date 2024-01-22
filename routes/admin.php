<?php

use App\Http\Controllers\V1\Admin\CategoryController;
use App\Http\Controllers\V1\Admin\MenuController;
use App\Http\Controllers\V1\Admin\RestaurantController;
use App\Http\Controllers\V1\Admin\RoleController;
use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/get-roles', [RoleController::class, 'getRoles']);

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // roles && auth
    Route::apiResource('/roles', RoleController::class);
    Route::post('/logout', [AuthController::class, 'logout']);

    //categories
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/restaurants', RestaurantController::class);

    // menus
    Route::controller(MenuController::class)->group(function () {
        Route::get('/menus', 'index');
        Route::post('/menus', 'store');
        Route::post('/menus/{menu}', 'update');
        Route::delete('/menus/{menu}', 'destroy');
    });
});

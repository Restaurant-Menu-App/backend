<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\Site\ApiFrontendController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/get-roles', [AuthController::class, 'getRoles']);

// categoreis
Route::controller(ApiFrontendController::class)->prefix('v1')->group(function () {

    Route::get('/categories/{category}', 'getCategory');
    Route::get('/categories', 'getCategories');

    // restaurants
    Route::get('/restaurants/{restaurant}', 'getRestaurant');
    Route::get('/restaurants', 'getRestaurants');

    // menu by restaurant
    Route::get('/restaurants/{restaurant}/menus', 'getMenusByRestaurant');
});

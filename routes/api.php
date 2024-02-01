<?php

use App\Http\Controllers\Site\V1\ReviewController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\Site\ApiFrontendController;
use App\Http\Controllers\V1\Site\UserFavoriteController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/get-roles', [AuthController::class, 'getRoles']);

Route::prefix('v1')->group(function () {
    // categories
    Route::controller(ApiFrontendController::class)->group(function () {

        Route::get('/categories/{category}', 'getCategory');
        Route::get('/categories', 'getCategories');

        Route::get('/categories/{category}/restaurants', 'getRestaurantsByCategory');

        // restaurants
        Route::get('/restaurants/{restaurant}', 'getRestaurant');
        Route::get('/restaurants', 'getRestaurants');

        // menu by restaurant
        Route::get('/restaurants/{restaurant}/menus', 'getMenusByRestaurant');
    });

    // review restaurants
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/restaurants/{restaurant}/reviews', 'restaurantReviews');
        Route::post('/restaurants/{restaurant}/reviews/store', 'reviewStore')->middleware('auth:sanctum');
        Route::patch('/restaurants/{restaurant}/reviews/{review}/update', 'reviewUpdate')->middleware('auth:sanctum');
        Route::delete('/restaurants/{restaurant}/reviews/{review}/destroy', 'reviewDestroy')->middleware('auth:sanctum');
    });

    // restaurant favorites
    Route::controller(UserFavoriteController::class)->group(function () {
        Route::post('/add-favorite/{user}/{restaurant}', 'store');
        Route::delete('/remove-favorite/{user}/{restaurant}', 'detach');
    });
});

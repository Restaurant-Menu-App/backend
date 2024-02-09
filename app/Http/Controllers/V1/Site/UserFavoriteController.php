<?php

namespace App\Http\Controllers\V1\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RestaurantResource;
use App\Http\Resources\V1\ReviewResource;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteController extends Controller
{
    public function store(User $user, Restaurant $restaurant)
    {
        $added_data = $user->restaurant_favorites()->where('restaurant_id', $restaurant->id)->first();

        if ($added_data) {
            return $this->sendError('Restaurant Already Added', 422);
        } else {
            $favorite = $user->restaurant_favorites()->attach($restaurant);

            $result = ReviewResource::collection($favorite);

            return $this->sendResponse($result, 'Added To Favorites');
        }
    }

    public function detach(User $user, Restaurant $restaurant)
    {
        $user->restaurant_favorites()->detach($restaurant);

        return $this->sendResponse([], 'Removed from Favorites');
    }

    public function getFavorites(User $user)
    {
        $restaurants = RestaurantResource::collection($user->restaurant_favorites);

        return $this->sendResponse($restaurants, "");
    }
}

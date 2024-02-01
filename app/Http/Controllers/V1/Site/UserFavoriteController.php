<?php

namespace App\Http\Controllers\V1\Site;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function store(User $user, Restaurant $restaurant)
    {
        $added_data = $user->restaurant_favorites()->where('restaurant_id', $restaurant->id)->first();

        if ($added_data) {
            return $this->sendError('Restaurant Already Added', 422);
        } else {
            $user->restaurant_favorites()->attach($restaurant);

            return $this->sendResponse('Added To Favorites', 200);
        }
    }

    public function detach(User $user, Restaurant $restaurant)
    {
        dd($restaurant);
        $user->restaurant_favorites()->detach($restaurant);

        return $this->sendResponse('Removed from Favorites', 200);
    }
}

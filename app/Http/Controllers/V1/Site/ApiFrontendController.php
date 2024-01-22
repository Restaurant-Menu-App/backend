<?php

namespace App\Http\Controllers\V1\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\RestaurantResource;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ApiFrontendController extends Controller
{
    // getcategories
    public function getCategory(Category $category)
    {
        return new CategoryResource($category);
    }

    public function getCategories()
    {
        $categories = Category::filterOn()->latest()->get();

        return CategoryResource::collection($categories);
    }

    // getRestaurant
    public function getRestaurant(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant->loadMissing('user'));
    }

    public function getRestaurants()
    {
        $perPage = request('per_page', 10);
        $restaurants = Restaurant::with(['user'])->inRandomOrder()->paginate($perPage);

        $restaurants = RestaurantResource::collection($restaurants)->response()->getData(true);

        return response()->json($restaurants, 200);
    }
}

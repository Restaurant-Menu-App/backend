<?php

namespace App\Http\Controllers\V1\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\MenuResource;
use App\Http\Resources\V1\RestaurantResource;
use App\Models\Category;
use App\Models\Menu;
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

    public function getRestaurantsByCategory(Category $category)
    {
        $perPage = request('per_page', 10);
        $restaurants = $category->restaurants()->inRandomOrder()->paginate($perPage);
        $restaurants = RestaurantResource::collection($restaurants)->response()->getData(true);

        return response()->json($restaurants, 200);
    }

    // getRestaurant
    public function getRestaurant(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant->loadMissing(['user', 'reviews', 'categories']));
    }

    public function getRestaurants()
    {
        $perPage = request('per_page', 10);
        $restaurants = Restaurant::with(['user', 'reviews', 'categories'])->filterOn()->inRandomOrder()->paginate($perPage);

        $restaurants = RestaurantResource::collection($restaurants)->response()->getData(true);

        return response()->json($restaurants, 200);
    }

    public function getMenusByRestaurant(Restaurant $restaurant)
    {
        $perPage = request('per_page', 10);
        $menus = Menu::with(['category', 'medias'])->where('restaurant_id', $restaurant->id)->latest()->paginate($perPage);

        // $menus = MenuResource::collection($restaurant->menus()->paginate()->loadMissing(['category', 'medias']))->response()->getData(true);

        $menus = MenuResource::collection($menus)->response()->getData(true);
        return response()->json($menus, 200);
    }
}

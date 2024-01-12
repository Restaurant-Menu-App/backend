<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RestaurantRequest;
use App\Http\Resources\V1\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::latest()->paginate(10);

        $restaurants = RestaurantResource::collection($restaurants);

        return response()->json([
            'restaurants' => $restaurants
        ], 200);
    }

    public function store(RestaurantRequest $request)
    {
        try {
            $restaurant = Restaurant::create([
                "name" => $request->name,
                "phone" => $request->phone,
                "email" => $request->email,
                "website_url" => $request->website_url,
                "desc" => $request->desc,
                "open_time" => $request->open_time,
                "close_time" => $request->close_time
            ]);
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }

        $restaurant = new RestaurantResource($restaurant);

        return $this->sendResponse($restaurant, 'Success!');
    }
}

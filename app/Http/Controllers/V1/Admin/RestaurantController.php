<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RestaurantRequest;
use App\Http\Resources\V1\RestaurantResource;
use App\Models\Restaurant;
use App\Services\RestaurantService;

class RestaurantController extends Controller
{
    private $restSvc;
    public function __construct(RestaurantService $restSvc)
    {
        $this->restSvc = $restSvc;
    }
    public function index()
    {
        $perPage = request('per_page', 10);
        $restaurants = Restaurant::with(['categories', 'user'])->filterOn()->latest()->paginate($perPage);

        $restaurants = RestaurantResource::collection($restaurants)->response()->getData(true);

        return response()->json($restaurants, 200);
    }

    public function store(RestaurantRequest $request)
    {
        $response = $this->restSvc->store($request->validated());

        $restaurant = new RestaurantResource($response);

        return $this->sendResponse($restaurant, 'Success!');
    }

    public function update(RestaurantRequest $request, $id)
    {
        $response = $this->restSvc->update($request->validated(), $id);

        $restaurant = new RestaurantResource($response);

        return $this->sendResponse($restaurant, 'Success!');
    }
}

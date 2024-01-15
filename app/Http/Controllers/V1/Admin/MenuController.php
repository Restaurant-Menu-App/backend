<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MenuRequest;
use App\Http\Resources\V1\MenuResource;
use App\Models\Menu;
use App\Services\MediaService;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    private $menuSvc;
    private $mediaSvc;

    public function __construct(MenuService $menuSvc, MediaService $mediaSvc)
    {
        $this->menuSvc = $menuSvc;
        $this->mediaSvc = $mediaSvc;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $menus = Menu::with(['restaurant', 'category'])->latest()->paginate($perPage);

        $menus = MenuResource::collection($menus)->response()->getData(true);
        return response()->json($menus, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $response = $this->menuSvc->store($request->validated());

        if ($request->file('medias')) {
            $mediaFormdata = [
                'medias' => $request->file('medias'),
                'type' => 'menus',
            ];

            $medias = $this->mediaSvc->storeMultiMedia($mediaFormdata);

            $response->medias()->sync($medias);
        } else {
            $media = null;
        }

        $restaurant = new MenuResource($response);

        return $this->sendResponse($restaurant, 'Success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, $id)
    {
        $response = $this->menuSvc->update($request->validated(), $id);

        $menu = new MenuResource($response);

        return $this->sendResponse($menu, 'Success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return $this->sendResponse([], 'Deleted!');
    }
}

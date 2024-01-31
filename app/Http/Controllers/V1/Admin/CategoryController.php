<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use App\Services\MediaService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $mediaSvc;

    public function __construct(MediaService $mediaSvc)
    {
        $this->mediaSvc = $mediaSvc;
    }

    public function index()
    {
        $perPage = request('per_page', 10);

        $categories = Category::filterOn()->paginate($perPage);

        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|string|min:3|unique:categories,name",
            'desc' => "nullable|string",
            'type' => "required|string|in:restaurant,menu",
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024'
        ]);
        $category = new Category();

        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->type = $request->type;
        $category->save();

        if ($request->hasFile('image')) {
            $mediaFormdata = [
                'media' => $request->file('image'),
                'type' => 'category',
            ];

            $url = $this->mediaSvc->storeMedia($mediaFormdata);

            $category->update([
                'image' => $url
            ]);
        }

        return response()->json(new CategoryResource($category), 200);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => "required|string|min:3|unique:categories,name," . $category->id,
            'desc' => "nullable|string",
            'type' => "required|string|in:restaurant,menu",
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024'
        ]);

        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->type = $request->type;
        $category->update();


        if ($request->hasFile('image')) {
            $mediaFormdata = [
                'media' => $request->file('image'),
                'type' => 'category',
            ];

            $url = $this->mediaSvc->storeMedia($mediaFormdata);

            $category->update([
                'image' => $url
            ]);
        }

        return response()->json(new CategoryResource($category), 200);
    }
}

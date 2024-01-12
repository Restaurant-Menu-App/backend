<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
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
        ]);
        $category = new Category();

        $category->slug = Str::slug($request->name);
        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->save();

        return response()->json(new CategoryResource($category), 200);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => "required|string|min:3|unique:categories,name," . $category->id,
            'desc' => "nullable|string",
        ]);

        $category->slug = Str::slug($request->name);
        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->update();

        return response()->json(new CategoryResource($category), 200);
    }
}

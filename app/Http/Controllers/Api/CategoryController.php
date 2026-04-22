<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->where('is_active', true);

        if ($request->boolean('tree')) {
            $query->whereNull('parent_id')->with(['children' => fn ($q) => $q->where('is_active', true)]);
        }

        $categories = $query->orderBy('sort_order')->orderBy('name')->get();
        return CategoryResource::collection($categories);
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $category->load(['children' => fn ($q) => $q->where('is_active', true)]);
        return new CategoryResource($category);
    }
}

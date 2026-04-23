<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort_order')->orderBy('name')->get();
        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']) . '-' . Str::random(4);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateData($request, $category->id);
        // Prevent creating a parent_id cycle: a category may not point to
        // itself or to one of its own descendants. Without this guard the
        // public ProductController category-tree expansion would previously
        // chase the cycle forever.
        if (array_key_exists('parent_id', $data) && $data['parent_id'] !== null) {
            if ($this->wouldCreateCycle($category->id, (int) $data['parent_id'])) {
                return response()->json([
                    'message' => 'Категория не может быть вложена сама в себя или в одного из своих потомков.',
                    'errors' => ['parent_id' => ['Циклическая иерархия недопустима.']],
                ], 422);
            }
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $category->update($data);
        return new CategoryResource($category);
    }

    protected function wouldCreateCycle(int $categoryId, int $newParentId): bool
    {
        if ($categoryId === $newParentId) {
            return true;
        }
        // Walk up from the candidate parent; if we hit $categoryId, it would
        // become its own ancestor. Bounded by a safety counter in case the
        // table already contains a pre-existing cycle.
        $cursor = $newParentId;
        for ($i = 0; $i < 64 && $cursor !== null; $i++) {
            $parent = Category::where('id', $cursor)->value('parent_id');
            if ($parent === null) {
                return false;
            }
            if ((int) $parent === $categoryId) {
                return true;
            }
            $cursor = (int) $parent;
        }
        return false;
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Удалено']);
    }

    protected function validateData(Request $request, ?int $categoryId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}

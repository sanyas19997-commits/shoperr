<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->boolean('flat')) {
            return Category::query()
                ->orderBy('parent_id')->orderBy('sort_order')->orderBy('name')
                ->get();
        }

        return $this->tree();
    }

    private function tree()
    {
        $all = Category::orderBy('sort_order')->orderBy('name')->get()->groupBy('parent_id');
        $build = function ($parentId) use (&$build, $all) {
            return ($all[$parentId] ?? collect())->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'is_active' => $c->is_active,
                'sort_order' => $c->sort_order,
                'children' => $build($c->id),
            ])->values();
        };
        return $build(null);
    }

    public function show(Category $category)
    {
        return response()->json(['data' => $category]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $category = Category::create($data);
        ActionLog::log('category.create', $category, $data);
        return response()->json(['data' => $category], 201);
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request, $category);
        if (($data['parent_id'] ?? null) === $category->id) {
            return response()->json(['message' => 'Категория не может быть родителем самой себе.'], 422);
        }
        $category->update($data);
        ActionLog::log('category.update', $category, $data);
        return response()->json(['data' => $category->fresh()]);
    }

    public function destroy(Request $request, Category $category)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('category.delete', $category);
        $category->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . substr(uniqid(), -4);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        return $data;
    }
}

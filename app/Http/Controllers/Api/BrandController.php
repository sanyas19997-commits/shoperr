<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $q = Brand::query();
        if ($s = $request->string('q')->toString()) {
            $q->where('name', 'like', "%$s%");
        }
        return $q->orderBy('name')->paginate($request->integer('per_page', 25));
    }

    public function all()
    {
        return Brand::where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);
    }

    public function show(Brand $brand)
    {
        return response()->json(['data' => $brand]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $brand = Brand::create($data);
        ActionLog::log('brand.create', $brand, $data);
        return response()->json(['data' => $brand], 201);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $this->validated($request, $brand);
        $brand->update($data);
        ActionLog::log('brand.update', $brand, $data);
        return response()->json(['data' => $brand->fresh()]);
    }

    public function destroy(Request $request, Brand $brand)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('brand.delete', $brand);
        $brand->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validated(Request $request, ?Brand $brand = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . substr(uniqid(), -4);
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }
        return $data;
    }
}

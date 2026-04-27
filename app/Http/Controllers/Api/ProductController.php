<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::with(['category:id,name,slug', 'brand:id,name,slug', 'images']);

        if ($s = $request->string('q')->toString()) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")
                  ->orWhere('sku', 'like', "%$s%");
            });
        }
        if ($cat = $request->integer('category_id')) {
            $q->where('category_id', $cat);
        }
        if ($brand = $request->integer('brand_id')) {
            $q->where('brand_id', $brand);
        }
        if ($request->filled('is_active')) {
            $q->where('is_active', $request->boolean('is_active'));
        }
        if ($request->filled('min_price')) {
            $q->where('price', '>=', (float) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $q->where('price', '<=', (float) $request->input('max_price'));
        }
        if ($request->filled('in_stock')) {
            $request->boolean('in_stock')
                ? $q->where('stock', '>', 0)
                : $q->where('stock', '<=', 0);
        }

        $sort = $request->input('sort', '-id');
        $dir = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $col = ltrim($sort, '-');
        if (in_array($col, ['id', 'name', 'price', 'stock', 'created_at'])) {
            $q->orderBy($col, $dir);
        }

        return $q->paginate($request->integer('per_page', 15));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'images']);
        return response()->json(['data' => $product]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $product = Product::create($data);
        $this->syncImages($product, $request);

        ActionLog::log('product.create', $product, $product->only(array_keys($data)));
        return response()->json(['data' => $product->fresh(['images', 'category', 'brand'])], 201);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product);
        $product->update($data);
        $this->syncImages($product, $request);

        ActionLog::log('product.update', $product, $data);
        return response()->json(['data' => $product->fresh(['images', 'category', 'brand'])]);
    }

    public function destroy(Request $request, Product $product)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('product.delete', $product);
        $product->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validateData(Request $request, ?Product $product = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:64'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ];

        $data = $request->validate($rules);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . substr(uniqid(), -4);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        return $data;
    }

    private function syncImages(Product $product, Request $request): void
    {
        if ($request->hasFile('images')) {
            foreach ((array) $request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['path' => $path, 'sort_order' => 0]);
            }
        }
    }
}

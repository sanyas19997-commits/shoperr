<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['images', 'category']);
        if ($request->filled('q')) {
            $query->search($request->input('q'));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }
        $query->latest();
        return ProductResource::collection($query->paginate(15));
    }

    public function show(Product $product)
    {
        $product->load(['images', 'category']);
        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']) . '-' . Str::random(5);
        $product = Product::create($data);

        $this->syncImages($product, $request);

        $product->load(['images', 'category']);
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product->id);
        $product->update($data);

        $this->syncImages($product, $request);

        $product->load(['images', 'category']);
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Удалено']);
    }

    protected function validateData(Request $request, ?int $productId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($productId)],
            'attributes' => ['nullable', 'array'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
            'image_urls' => ['nullable', 'array'],
            'image_urls.*' => ['string'],
            'primary_image_index' => ['nullable', 'integer'],
        ]);
    }

    protected function syncImages(Product $product, Request $request): void
    {
        $uploaded = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $uploaded[] = ['path' => $path];
            }
        }

        if ($request->filled('image_urls')) {
            foreach ($request->input('image_urls', []) as $url) {
                $uploaded[] = ['path' => $url];
            }
        }

        $primaryIndex = (int) $request->input('primary_image_index', 0);

        if (!empty($uploaded)) {
            if ($product->images()->count() === 0) {
                foreach ($uploaded as $i => $row) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $row['path'],
                        'sort_order' => $i,
                        'is_primary' => $i === $primaryIndex,
                    ]);
                }
            } else {
                $offset = $product->images()->count();
                foreach ($uploaded as $i => $row) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $row['path'],
                        'sort_order' => $offset + $i,
                        'is_primary' => false,
                    ]);
                }
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request, ?string $categorySlug = null)
    {
        $category = null;

        if ($categorySlug) {
            $category = Category::query()->where('slug', $categorySlug)->firstOrFail();
        }

        $query = Product::query()->with('category:id,name,slug')->where('is_active', true);

        if ($category) {
            $childIds = $category->children()->pluck('id')->push($category->id);
            $query->whereIn('category_id', $childIds);
        }

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($min = $request->query('price_min')) {
            $query->where('price', '>=', (float) $min);
        }

        if ($max = $request->query('price_max')) {
            $query->where('price', '<=', (float) $max);
        }

        $sort = $request->query('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('shop.catalog', [
            'products' => $products,
            'category' => $category,
            'categories' => $categories,
            'search' => $search,
            'sort' => $sort,
            'filters' => [
                'price_min' => $request->query('price_min'),
                'price_max' => $request->query('price_max'),
            ],
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::query()
            ->with(['category:id,name,slug', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Product::query()
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->with('category:id,name,slug')
            ->take(4)
            ->get();

        return view('shop.product', compact('product', 'related'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->active()->with(['images', 'category']);

        // Category filter (by id or slug)
        if ($request->filled('category')) {
            $categorySlugOrId = $request->input('category');
            $category = is_numeric($categorySlugOrId)
                ? Category::find($categorySlugOrId)
                : Category::where('slug', $categorySlugOrId)->first();
            if ($category) {
                $descendantIds = $this->collectDescendantIds($category);
                $query->whereIn('category_id', $descendantIds);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        // In stock
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Featured
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        // Search
        $query->search($request->input('q'));

        // Sorting
        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'rating' => $query->orderByDesc('rating')->orderByDesc('reviews_count'),
            'popular' => $query->orderByDesc('views')->orderByDesc('reviews_count'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('created_at'),
        };

        $perPage = min(max((int) $request->input('per_page', 12), 1), 60);
        $products = $query->paginate($perPage)->withQueryString();

        return ProductResource::collection($products);
    }

    public function show(string $slug)
    {
        $product = Product::with(['images', 'category'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $product->increment('views');

        $similar = Product::active()
            ->with(['images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(8)
            ->get();

        return response()->json([
            'data' => new ProductResource($product),
            'similar' => ProductResource::collection($similar),
        ]);
    }

    public function reviews(Product $product)
    {
        $reviews = $product->reviews()
            ->with('user')
            ->where('is_approved', true)
            ->latest()
            ->paginate(10);
        return ReviewResource::collection($reviews);
    }

    protected function collectDescendantIds(Category $category): array
    {
        // Iterative BFS. We track visited ids so a corrupted categories.parent_id
        // cycle (A -> B -> A) can't send this loop — and thus the public
        // catalog endpoint — into an unbounded memory/CPU spin.
        $visited = [$category->id => true];
        $ids = [$category->id];
        $stack = [$category->id];
        while (!empty($stack)) {
            $current = array_pop($stack);
            $childIds = Category::where('parent_id', $current)->pluck('id')->all();
            foreach ($childIds as $childId) {
                if (!isset($visited[$childId])) {
                    $visited[$childId] = true;
                    $ids[] = $childId;
                    $stack[] = $childId;
                }
            }
        }
        return $ids;
    }
}

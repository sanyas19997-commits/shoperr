<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Attribute filter: ?attrs[color]=red,blue&attrs[size]=m
        // The `attributes` column is JSON (`{color: 'red', size: 'm', …}`). We
        // match with a naive LIKE on the raw JSON so we stay compatible with
        // both MySQL and SQLite — storage is small (per-product) so this is
        // cheap. Multiple values for the same key are OR-ed, different keys
        // are AND-ed.
        $selectedAttrs = $this->normalizeAttrsInput($request->input('attrs', []));
        foreach ($selectedAttrs as $key => $values) {
            $query->where(function ($q) use ($key, $values) {
                foreach ($values as $v) {
                    $needle = json_encode([$key => $v], JSON_UNESCAPED_UNICODE);
                    // `{"color":"red"}` stripped of the braces gives the kv pair
                    // that appears verbatim in the stored JSON blob.
                    $kv = trim($needle, '{}');
                    $q->orWhere('attributes', 'like', '%' . $kv . '%');
                }
            });
        }

        // Build facets from the *category-scoped* set so the filter sidebar
        // shows every attribute value available in the current section — not
        // just the ones that survived the currently-selected filters.
        $facetQuery = (clone $query->getQuery());
        // Strip the attribute-LIKE filters we just added so facet counts
        // reflect "what's available", not "what matches current selection".
        // We approximate this by re-running the base filter set (category +
        // price + in_stock + search) without attrs.
        $facets = $this->buildAttributeFacets($this->baseFilterQuery($request));

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

        return ProductResource::collection($products)->additional([
            'facets' => $facets,
        ]);
    }

    /**
     * GET /api/products/search?q=...
     *
     * Lightweight endpoint for the navbar autocomplete — returns up to 10
     * active products matching `q` (name / sku / brand) with just the fields
     * we need in the dropdown. Avoids the full `/api/products` payload.
     */
    public function search(Request $request)
    {
        $term = trim((string) $request->input('q', ''));
        if (mb_strlen($term) < 2) {
            return response()->json(['data' => []]);
        }
        $limit = min(max((int) $request->input('limit', 8), 1), 20);

        $products = Product::active()
            ->with(['primaryImage', 'category'])
            ->search($term)
            ->orderByDesc('views')
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $products->map(fn (Product $p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => (float) $p->price,
                'old_price' => $p->old_price !== null ? (float) $p->old_price : null,
                'image_url' => $p->primary_image_url,
                'category' => $p->category ? [
                    'name' => $p->category->name,
                    'slug' => $p->category->slug,
                ] : null,
            ])->values(),
        ]);
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

    /**
     * Normalize attribute filter input — callers may send it as an array
     * (`attrs[color][]=red`) or as a comma-joined string (`attrs[color]=red,blue`).
     */
    protected function normalizeAttrsInput($raw): array
    {
        if (!is_array($raw)) {
            return [];
        }
        $out = [];
        foreach ($raw as $key => $val) {
            $key = (string) $key;
            if ($key === '' || !preg_match('/^[A-Za-z0-9_\-]+$/u', $key)) {
                // Block anything that could break the LIKE predicate / JSON lookup.
                continue;
            }
            if (is_array($val)) {
                $values = $val;
            } elseif (is_string($val) && str_contains($val, ',')) {
                $values = explode(',', $val);
            } else {
                $values = [$val];
            }
            $values = array_values(array_filter(array_map(fn ($v) => trim((string) $v), $values), fn ($v) => $v !== ''));
            if ($values) {
                $out[$key] = $values;
            }
        }
        return $out;
    }

    /**
     * Base query used to compute attribute facets — applies category/price/
     * stock/search filters but NOT the `attrs[…]` filter, so we can show
     * "other values available" even when the user has already selected one.
     */
    protected function baseFilterQuery(Request $request)
    {
        $query = Product::query()->active();
        if ($request->filled('category')) {
            $categorySlugOrId = $request->input('category');
            $category = is_numeric($categorySlugOrId)
                ? Category::find($categorySlugOrId)
                : Category::where('slug', $categorySlugOrId)->first();
            if ($category) {
                $query->whereIn('category_id', $this->collectDescendantIds($category));
            } else {
                $query->whereRaw('1 = 0');
            }
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }
        $query->search($request->input('q'));
        return $query;
    }

    /**
     * Aggregate `attributes` JSON across the visible set into a facet map:
     *   { color: [{value: 'red', count: 12}, …], size: [...] }
     *
     * Cheap and portable — we pull just the `attributes` column and bucket
     * in PHP. Assumes scalar attribute values (strings/numbers).
     */
    protected function buildAttributeFacets($baseQuery): array
    {
        $rows = (clone $baseQuery)->pluck('attributes');
        $buckets = [];
        foreach ($rows as $row) {
            // Product.attributes is cast to array by the model, but pluck
            // returns the raw stored value — decode if we got a string.
            $attrs = is_string($row) ? json_decode($row, true) : $row;
            if (!is_array($attrs)) {
                continue;
            }
            foreach ($attrs as $key => $value) {
                if (!is_string($key) || !preg_match('/^[A-Za-z0-9_\-]+$/u', $key)) {
                    continue;
                }
                if (is_array($value)) {
                    // Array-valued attribute ({"colors":["red","blue"]}) — bucket each.
                    foreach ($value as $v) {
                        $this->bucket($buckets, $key, $v);
                    }
                } else {
                    $this->bucket($buckets, $key, $value);
                }
            }
        }
        // Emit a stable, sorted shape the frontend can render without fuss.
        $out = [];
        foreach ($buckets as $key => $map) {
            $values = [];
            foreach ($map as $v => $count) {
                $values[] = ['value' => (string) $v, 'count' => $count];
            }
            usort($values, fn ($a, $b) => $b['count'] <=> $a['count'] ?: strcmp($a['value'], $b['value']));
            $out[] = [
                'code' => $key,
                'label' => $this->humanizeAttrLabel($key),
                'values' => $values,
            ];
        }
        // Stable order — put color / size / brand up top when present.
        $priority = ['color' => 0, 'size' => 1, 'brand' => 2, 'material' => 3];
        usort($out, function ($a, $b) use ($priority) {
            $pa = $priority[$a['code']] ?? 99;
            $pb = $priority[$b['code']] ?? 99;
            return $pa === $pb ? strcmp($a['code'], $b['code']) : $pa - $pb;
        });
        return $out;
    }

    protected function bucket(array &$buckets, string $key, $value): void
    {
        if ($value === null || $value === '') {
            return;
        }
        $v = (string) $value;
        if (mb_strlen($v) > 60) {
            // Long free-form text (e.g. full descriptions) isn't useful as a facet.
            return;
        }
        if (!isset($buckets[$key])) {
            $buckets[$key] = [];
        }
        $buckets[$key][$v] = ($buckets[$key][$v] ?? 0) + 1;
    }

    protected function humanizeAttrLabel(string $code): string
    {
        $map = [
            'color' => 'Цвет',
            'size' => 'Размер',
            'brand' => 'Бренд',
            'material' => 'Материал',
            'weight' => 'Вес',
            'model' => 'Модель',
            'memory' => 'Память',
            'ram' => 'ОЗУ',
            'screen' => 'Экран',
            'type' => 'Тип',
        ];
        return $map[strtolower($code)] ?? ucfirst(str_replace(['_', '-'], ' ', $code));
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'body' => ['nullable', 'string', 'max:2000'],
        ]);

        $review = Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => $request->user()->id],
            [
                'rating' => $data['rating'],
                'body' => $data['body'] ?? null,
                'is_approved' => true,
            ]
        );

        $product->loadCount(['reviews' => fn ($q) => $q->where('is_approved', true)]);
        $avg = $product->reviews()->where('is_approved', true)->avg('rating');
        $product->update([
            'rating' => round((float) $avg, 2),
            'reviews_count' => $product->reviews_count,
        ]);

        $review->load('user');
        return new ReviewResource($review);
    }

    public function destroy(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $productId = $review->product_id;
        $review->delete();
        $product = Product::find($productId);
        if ($product) {
            $avg = $product->reviews()->where('is_approved', true)->avg('rating');
            $count = $product->reviews()->where('is_approved', true)->count();
            $product->update(['rating' => round((float) $avg, 2), 'reviews_count' => $count]);
        }
        return response()->json(['message' => 'Удалено']);
    }
}

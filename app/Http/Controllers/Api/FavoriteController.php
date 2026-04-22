<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = $request->user()->favorites()->with('images')->paginate(20);
        return ProductResource::collection($favorites);
    }

    public function toggle(Request $request, Product $product)
    {
        $user = $request->user();
        $result = $user->favorites()->toggle($product->id);
        $isFavorite = !empty($result['attached']);
        return response()->json([
            'is_favorite' => $isFavorite,
            'product_id' => $product->id,
        ]);
    }
}

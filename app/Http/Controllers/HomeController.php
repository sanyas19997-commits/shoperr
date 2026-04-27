<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        if ($featured->isEmpty()) {
            $featured = Product::query()
                ->where('is_active', true)
                ->with('category')
                ->latest()
                ->take(8)
                ->get();
        }

        $newest = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $onSale = Product::query()
            ->where('is_active', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereColumn('sale_price', '<', 'price')
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $popular = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->inRandomOrder()
            ->take(8)
            ->get();

        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('shop.home', compact('featured', 'newest', 'onSale', 'popular', 'categories'));
    }
}

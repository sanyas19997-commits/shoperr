<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with('category:id,name,slug')
            ->latest()
            ->take(8)
            ->get();

        if ($featured->isEmpty()) {
            $featured = Product::query()
                ->where('is_active', true)
                ->with('category:id,name,slug')
                ->latest()
                ->take(8)
                ->get();
        }

        $newest = Product::query()
            ->where('is_active', true)
            ->with('category:id,name,slug')
            ->latest()
            ->take(8)
            ->get();

        $onSale = Product::query()
            ->where('is_active', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereColumn('sale_price', '<', 'price')
            ->with('category:id,name,slug')
            ->latest()
            ->take(8)
            ->get();

        $popular = Product::query()
            ->where('is_active', true)
            ->with('category:id,name,slug')
            ->inRandomOrder()
            ->take(8)
            ->get();

        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get(['id', 'name', 'slug', 'image']);

        return view('shop.home', [
            'featured' => $featured,
            'newest' => $newest,
            'onSale' => $onSale,
            'popular' => $popular,
            'categories' => $categories,
            'promo' => [
                'title' => Setting::get('promo_title', 'Спецпредложение'),
                'text' => Setting::get('promo_text', 'Скидки на популярные категории. Успей купить по выгодной цене!'),
            ],
        ]);
    }
}

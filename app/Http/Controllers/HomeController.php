<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\InstagramPost;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Testimonial;

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

        $banners = Banner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('place');

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $instagram = InstagramPost::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('shop.home', [
            'featured' => $featured,
            'newest' => $newest,
            'onSale' => $onSale,
            'popular' => $popular,
            'categories' => $categories,
            'banners' => $banners,
            'testimonials' => $testimonials,
            'instagram' => $instagram,
            'homeTexts' => [
                'featured' => Setting::get('home_featured_title', 'Рекомендуемые товары'),
                'newest' => Setting::get('home_newest_title', 'Новинки'),
                'popular' => Setting::get('home_popular_title', 'Популярные товары'),
                'deal' => Setting::get('home_deal_title', 'Горячие предложения'),
                'testimonials' => Setting::get('home_testimonials_title', 'Отзывы наших клиентов'),
                'instagram' => Setting::get('home_instagram_title', 'Мы в Instagram'),
                'categories' => Setting::get('home_categories_title', 'Категории'),
                'brands' => Setting::get('home_brands_title', 'Наши бренды'),
                'best_sellers' => Setting::get('home_best_sellers_title', 'Хиты продаж'),
            ],
            'promo' => [
                'title' => Setting::get('promo_title', 'Спецпредложение'),
                'text' => Setting::get('promo_text', 'Скидки на популярные категории. Успей купить по выгодной цене!'),
            ],
        ]);
    }
}

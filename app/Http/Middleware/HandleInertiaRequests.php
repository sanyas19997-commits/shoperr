<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * Корневой Blade-шаблон для первичной загрузки SPA-витрины.
     */
    protected $rootView = 'shop-app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Глобальные props, доступные на каждой странице витрины.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $cart = app(CartService::class);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => fn () => $request->user()
                    ? [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        'role' => $request->user()->role ?? null,
                    ]
                    : null,
            ],
            'cart' => fn () => [
                'count' => $cart->count(),
                'subtotal' => $cart->subtotal(),
            ],
            'site' => fn () => [
                'name' => Setting::get('site_name', 'Billaro Store'),
                'description' => Setting::get('site_description', 'Качественные товары для всей семьи'),
                'phone' => Setting::get('site_phone', '+7 (495) 123-45-67'),
                'email' => Setting::get('site_email', 'info@billaro.store'),
                'address' => Setting::get('site_address', 'Москва'),
                'logo' => Setting::get('site_logo'),
                'free_shipping_text' => Setting::get('free_shipping_text', 'Бесплатная доставка при заказе от 5 000 ₽'),
            ],
            'mainCategories' => fn () => Category::query()
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug'])
                ->toArray(),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}

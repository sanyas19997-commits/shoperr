<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ShareShopData
{
    public function __construct(protected CartService $cart)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        // Shared data только для витрины — админка-SPA не задевается.
        if (! $request->is('admin*') && ! $request->is('api*')) {
            View::share('siteSettings', $this->siteSettings());
            View::share('mainCategories', $this->mainCategories());
            View::share('cartCount', $this->cart->count());
            View::share('cartSubtotal', $this->cart->subtotal());
            View::share('headerMenu', $this->menu('header'));
            View::share('footerShopMenu', $this->menu('footer_shop'));
            View::share('footerCustomersMenu', $this->menu('footer_customers'));
            View::share('footerHelpMenu', $this->menu('footer_help'));
        }

        return $next($request);
    }

    protected function siteSettings(): array
    {
        try {
            return Setting::all()->pluck('value', 'key')->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    protected function menu(string $placement)
    {
        try {
            return MenuItem::for($placement)->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    protected function mainCategories()
    {
        try {
            return Category::query()
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}

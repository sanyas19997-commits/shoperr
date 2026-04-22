<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $revenue = Order::whereIn('status', ['completed', 'shipped', 'processing'])->sum('total');

        return response()->json([
            'stats' => [
                'users' => User::count(),
                'products' => Product::count(),
                'orders' => Order::count(),
                'new_orders' => Order::where('status', 'new')->count(),
                'revenue' => (float) $revenue,
            ],
            'recent_orders' => Order::latest()->limit(5)->get(),
            'top_products' => Product::orderByDesc('views')->limit(5)->with('images')->get()->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'views' => $p->views,
                'image_url' => $p->primary_image_url,
            ]),
        ]);
    }
}

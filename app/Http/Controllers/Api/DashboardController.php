<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();

        $stats = [
            'orders_total' => Order::count(),
            'orders_today' => Order::whereDate('created_at', $today)->count(),
            'orders_new' => Order::where('status', 'new')->count(),
            'revenue_today' => (float) Order::whereDate('created_at', $today)
                ->whereNotIn('status', ['canceled'])->sum('total'),
            'revenue_month' => (float) Order::where('created_at', '>=', $monthStart)
                ->whereNotIn('status', ['canceled'])->sum('total'),
            'products_total' => Product::count(),
            'products_active' => Product::where('is_active', true)->count(),
            'products_low_stock' => Product::where('stock', '<=', 5)->count(),
            'users_total' => User::where('role', User::ROLE_CUSTOMER)->count(),
            'staff_total' => User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_MANAGER])->count(),
        ];

        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()->take(8)->get()
            ->map(fn ($o) => [
                'id' => $o->id,
                'number' => $o->number,
                'total' => (float) $o->total,
                'status' => $o->status,
                'status_label' => $o->status_label,
                'customer_name' => $o->customer_name,
                'created_at' => $o->created_at,
            ]);

        $salesChart = $this->salesChart();

        return response()->json([
            'stats' => $stats,
            'recent_orders' => $recentOrders,
            'sales_chart' => $salesChart,
        ]);
    }

    private function salesChart(): array
    {
        $start = Carbon::now()->subDays(13)->startOfDay();
        $rows = Order::select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', $start)
            ->whereNotIn('status', ['canceled'])
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $orders = [];
        $revenue = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = Carbon::now()->subDays($i)->toDateString();
            $labels[] = Carbon::parse($d)->format('d.m');
            $row = $rows->get($d);
            $orders[] = $row ? (int) $row->orders_count : 0;
            $revenue[] = $row ? (float) $row->revenue : 0;
        }

        return ['labels' => $labels, 'orders' => $orders, 'revenue' => $revenue];
    }
}

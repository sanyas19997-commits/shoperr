<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with('items.product.images')
            ->latest()
            ->paginate(15);
        return OrderResource::collection($orders);
    }

    public function show(Request $request, int $id)
    {
        $order = $request->user()->orders()->with('items.product.images')->findOrFail($id);
        return new OrderResource($order);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:32'],
            'customer_email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $this->cartService->getCart($request);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return response()->json(['message' => 'Корзина пуста'], 422);
        }

        try {
            $order = DB::transaction(function () use ($cart, $data, $request) {
                $productIds = $cart->items->pluck('product_id')->all();
                $products = \App\Models\Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $outOfStock = [];
                foreach ($cart->items as $item) {
                    $product = $products->get($item->product_id);
                    if (!$product || $product->stock < $item->quantity) {
                        $outOfStock[] = [
                            'product_id' => $item->product_id,
                            'name' => $product?->name ?? ($item->product?->name ?? 'Товар'),
                            'requested' => $item->quantity,
                            'available' => $product?->stock ?? 0,
                        ];
                    }
                }
                if ($outOfStock) {
                    throw new \App\Exceptions\InsufficientStockException($outOfStock);
                }

                // Use the freshly locked product prices as the source of truth.
                // The cart item's price column is a cache of the price at add-to-cart
                // time and may be stale if the product was updated in the meantime.
                $total = 0;
                foreach ($cart->items as $item) {
                    $product = $products->get($item->product_id);
                    $total += (float) $product->price * $item->quantity;
                }

                $order = Order::create([
                    'number' => Order::generateNumber(),
                    'user_id' => $request->user()?->id,
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'customer_email' => $data['customer_email'],
                    'shipping_address' => $data['shipping_address'],
                    'comment' => $data['comment'] ?? null,
                    'total' => $total,
                    'status' => 'new',
                ]);

                foreach ($cart->items as $item) {
                    $product = $products->get($item->product_id);
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'product_name' => $product->name ?? 'Товар',
                        'price' => $product->price,
                        'quantity' => $item->quantity,
                        'subtotal' => (float) $product->price * $item->quantity,
                    ]);
                    $product->decrement('stock', $item->quantity);
                }

                $cart->items()->delete();

                return $order;
            });
        } catch (\App\Exceptions\InsufficientStockException $e) {
            return response()->json([
                'message' => 'Недостаточно товара на складе',
                'items' => $e->items,
            ], 422);
        }

        $order->load('items.product.images');
        return response()->json(['data' => new OrderResource($order)], 201);
    }
}

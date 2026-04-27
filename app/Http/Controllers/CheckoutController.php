<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart)
    {
    }

    public function index()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        return Inertia::render('Shop/Checkout', [
            'items' => array_values($this->cart->items()),
            'subtotal' => $this->cart->subtotal(),
            'paymentMethods' => Order::PAYMENT_METHODS,
            'deliveryMethods' => Order::DELIVERY_METHODS,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'delivery_method' => 'required|in:'.implode(',', array_keys(Order::DELIVERY_METHODS)),
            'payment_method' => 'required|in:'.implode(',', array_keys(Order::PAYMENT_METHODS)),
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'comment' => 'nullable|string|max:1000',
        ]);

        $order = DB::transaction(function () use ($data) {
            $subtotal = $this->cart->subtotal();
            $shipping = $data['delivery_method'] === 'pickup' ? 0 : 350;

            $order = Order::create([
                'number' => 'BS-'.now()->format('ymd').'-'.strtoupper(Str::random(5)),
                'user_id' => auth()->id(),
                'status' => 'new',
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'delivery_method' => $data['delivery_method'],
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
                'city' => $data['city'] ?? null,
                'address' => $data['address'] ?? null,
                'comment' => $data['comment'] ?? null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'discount' => 0,
                'total' => $subtotal + $shipping,
            ]);

            foreach ($this->cart->items() as $row) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $row['id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
                    'subtotal' => round($row['price'] * $row['quantity'], 2),
                ]);
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('checkout.success', $order)->with('success', 'Заказ оформлен!');
    }

    public function success(Order $order)
    {
        return Inertia::render('Shop/CheckoutSuccess', [
            'order' => $order,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart)
    {
    }

    public function index()
    {
        return view('shop.cart', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'nullable|integer|min:1|max:99']);

        if (! $product->is_active) {
            abort(404);
        }

        $this->cart->add($product, (int) ($request->input('quantity', 1)));

        if ($request->wantsJson()) {
            return response()->json([
                'count' => $this->cart->count(),
                'subtotal' => $this->cart->subtotal(),
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function update(Request $request, int $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:99']);
        $this->cart->update($productId, (int) $request->input('quantity'));

        if ($request->wantsJson()) {
            return response()->json([
                'count' => $this->cart->count(),
                'subtotal' => $this->cart->subtotal(),
            ]);
        }

        return back();
    }

    public function remove(int $productId)
    {
        $this->cart->remove($productId);

        return back();
    }

    public function clear()
    {
        $this->cart->clear();

        return back();
    }

    public function summary()
    {
        return response()->json([
            'count' => $this->cart->count(),
            'subtotal' => $this->cart->subtotal(),
            'items' => array_values($this->cart->items()),
        ]);
    }
}

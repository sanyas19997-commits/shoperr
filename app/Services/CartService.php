<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartService
{
    public function getCart(Request $request): Cart
    {
        $user = $request->user();
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            // Merge session cart if any
            $sessionId = $request->cookie('cart_session');
            if ($sessionId) {
                $sessionCart = Cart::where('session_id', $sessionId)->first();
                if ($sessionCart && $sessionCart->id !== $cart->id) {
                    $this->mergeCarts($sessionCart, $cart);
                }
            }
            return $cart;
        }

        $sessionId = $request->cookie('cart_session');
        if (!$sessionId) {
            $sessionId = (string) Str::uuid();
            cookie()->queue(cookie()->forever('cart_session', $sessionId));
        }

        return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null]);
    }

    public function addItem(Cart $cart, Product $product, int $quantity): void
    {
        $existing = $cart->items()->where('product_id', $product->id)->first();
        if ($existing) {
            $existing->quantity += $quantity;
            $existing->price = $product->price;
            $existing->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => max(1, $quantity),
                'price' => $product->price,
            ]);
        }
    }

    public function updateItem(Cart $cart, int $itemId, int $quantity): void
    {
        $item = $cart->items()->findOrFail($itemId);
        if ($quantity <= 0) {
            $item->delete();
            return;
        }
        $item->update(['quantity' => $quantity]);
    }

    public function removeItem(Cart $cart, int $itemId): void
    {
        $cart->items()->where('id', $itemId)->delete();
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }

    protected function mergeCarts(Cart $from, Cart $to): void
    {
        foreach ($from->items as $item) {
            $existing = $to->items()->where('product_id', $item->product_id)->first();
            if ($existing) {
                $existing->quantity += $item->quantity;
                $existing->save();
            } else {
                $to->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }
        }
        $from->items()->delete();
        $from->delete();
    }
}

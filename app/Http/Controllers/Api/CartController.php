<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function show(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $cart->load('items.product.images');
        return new CartResource($cart);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);
        $product = Product::active()->findOrFail($data['product_id']);
        $cart = $this->cartService->getCart($request);
        $this->cartService->addItem($cart, $product, $data['quantity'] ?? 1);
        $cart->load('items.product.images');
        return new CartResource($cart);
    }

    public function update(Request $request, int $itemId)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:999'],
        ]);
        $cart = $this->cartService->getCart($request);
        $this->cartService->updateItem($cart, $itemId, $data['quantity']);
        $cart->load('items.product.images');
        return new CartResource($cart);
    }

    public function remove(Request $request, int $itemId)
    {
        $cart = $this->cartService->getCart($request);
        $this->cartService->removeItem($cart, $itemId);
        $cart->load('items.product.images');
        return new CartResource($cart);
    }

    public function clear(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $this->cartService->clear($cart);
        $cart->load('items.product.images');
        return new CartResource($cart);
    }
}

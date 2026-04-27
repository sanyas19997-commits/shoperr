<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected const KEY = 'cart.items';

    /** @return array<int, array{id:int,name:string,slug:string,price:float,image:?string,quantity:int}> */
    public function items(): array
    {
        return Session::get(self::KEY, []);
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $items = $this->items();
        $id = $product->id;

        if (isset($items[$id])) {
            $items[$id]['quantity'] += $quantity;
        } else {
            $items[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->current_price,
                'image' => $product->main_image,
                'quantity' => max(1, $quantity),
            ];
        }

        Session::put(self::KEY, $items);
    }

    public function update(int $productId, int $quantity): void
    {
        $items = $this->items();

        if (! isset($items[$productId])) {
            return;
        }

        if ($quantity < 1) {
            unset($items[$productId]);
        } else {
            $items[$productId]['quantity'] = $quantity;
        }

        Session::put(self::KEY, $items);
    }

    public function remove(int $productId): void
    {
        $items = $this->items();
        unset($items[$productId]);
        Session::put(self::KEY, $items);
    }

    public function clear(): void
    {
        Session::forget(self::KEY);
    }

    public function count(): int
    {
        return array_sum(array_column($this->items(), 'quantity'));
    }

    public function subtotal(): float
    {
        $sum = 0.0;
        foreach ($this->items() as $row) {
            $sum += $row['price'] * $row['quantity'];
        }

        return round($sum, 2);
    }

    public function isEmpty(): bool
    {
        return empty($this->items());
    }
}

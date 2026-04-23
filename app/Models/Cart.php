<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function total(): float
    {
        return (float) $this->items->sum(fn ($i) => $i->price * $i->quantity);
    }

    /**
     * Total quantity of items in the cart (sum of all line quantities).
     *
     * Named `itemCount()` rather than `count()` because Eloquent models
     * forward unknown instance calls to the underlying query builder, so
     * defining `count()` on the model would mean `$cart->count()` returned
     * a line-quantity sum while `Cart::count()` (static) returned a SQL
     * row count. Avoiding the overload keeps semantics obvious.
     */
    public function itemCount(): int
    {
        return (int) $this->items->sum('quantity');
    }
}

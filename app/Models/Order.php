<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = ['new', 'processing', 'shipped', 'completed', 'cancelled'];

    protected $fillable = [
        'number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'comment',
        'total',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateNumber(): string
    {
        // UUID v4 avoids the microsecond-collision window that `uniqid()` has,
        // which previously could surface the unique-index on `orders.number` as
        // a 500 to concurrent customers.
        return 'ORD-' . strtoupper(\Illuminate\Support\Str::uuid()->toString());
    }
}

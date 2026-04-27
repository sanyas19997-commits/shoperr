<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = [
        'new' => 'Новый',
        'processing' => 'В обработке',
        'paid' => 'Оплачен',
        'shipped' => 'Отправлен',
        'delivered' => 'Доставлен',
        'canceled' => 'Отменён',
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'Наличными при получении',
        'card_courier' => 'Картой курьеру',
        'card_online' => 'Картой онлайн',
        'invoice' => 'Безналичный расчёт',
    ];

    public const DELIVERY_METHODS = [
        'courier' => 'Курьерская доставка',
        'pickup' => 'Самовывоз',
        'post' => 'Почта России',
        'cdek' => 'СДЭК',
    ];

    protected $fillable = [
        'number',
        'user_id',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_method',
        'payment_method',
        'payment_status',
        'city',
        'address',
        'comment',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
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

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? $this->payment_method;
    }

    public function getDeliveryMethodLabelAttribute(): string
    {
        return self::DELIVERY_METHODS[$this->delivery_method] ?? $this->delivery_method;
    }
}

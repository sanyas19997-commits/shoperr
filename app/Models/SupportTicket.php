<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SupportTicket extends Model
{
    use HasFactory;

    public const STATUS_OPEN = 'open';
    public const STATUS_ANSWERED = 'answered';
    public const STATUS_PENDING = 'pending';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'last_message_at',
        'user_unread',
        'admin_unread',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'user_unread' => 'integer',
        'admin_unread' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class, 'ticket_id')->orderBy('created_at');
    }

    // `latestOfMany()` produces a has-one-of-many relationship, so this
    // method must be typed as HasOne, not HasMany. Using HasMany caused a
    // PHP TypeError at runtime that Laravel surfaced as "undefined
    // relationship [latestMessage]".
    public function latestMessage(): HasOne
    {
        return $this->hasOne(SupportMessage::class, 'ticket_id')->latestOfMany();
    }
}

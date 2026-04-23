<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'old_price',
        'stock',
        'sku',
        'attributes',
        'category_id',
        'is_active',
        'is_featured',
        'rating',
        'reviews_count',
        'views',
    ];

    protected $casts = [
        'attributes' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    protected $appends = ['in_stock', 'discount_percent', 'primary_image_url'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favoredBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (!$this->old_price || (float)$this->old_price <= (float)$this->price) {
            return null;
        }
        return (int) round((((float)$this->old_price - (float)$this->price) / (float)$this->old_price) * 100);
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $image = $this->relationLoaded('primaryImage')
            ? $this->primaryImage
            : ($this->relationLoaded('images') ? $this->images->firstWhere('is_primary', true) ?? $this->images->first() : null);

        if (!$image) {
            $image = $this->images()->orderByDesc('is_primary')->first();
        }
        return $image?->url;
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('is_featured', true);
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        if (!$term) {
            return $q;
        }
        return $q->where(function ($sub) use ($term) {
            $sub->where('name', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%");
        });
    }
}

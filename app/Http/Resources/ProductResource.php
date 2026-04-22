<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => (float) $this->price,
            'old_price' => $this->old_price !== null ? (float) $this->old_price : null,
            'discount_percent' => $this->discount_percent,
            'stock' => $this->stock,
            'in_stock' => $this->in_stock,
            'sku' => $this->sku,
            'attributes' => $this->attributes,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'rating' => (float) $this->rating,
            'reviews_count' => $this->reviews_count,
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'primary_image_url' => $this->primary_image_url,
            'created_at' => $this->created_at,
        ];
    }
}

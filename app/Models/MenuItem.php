<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['placement', 'title', 'url', 'sort_order', 'is_active', 'open_new_tab'];
    protected $casts = ['is_active' => 'boolean', 'open_new_tab' => 'boolean', 'sort_order' => 'integer'];

    public function scopeFor($q, string $placement)
    {
        return $q->where('placement', $placement)->where('is_active', true)->orderBy('sort_order');
    }
}

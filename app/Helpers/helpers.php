<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    /**
     * Resolve a media path to a public URL.
     *
     * Rules:
     *  - empty / null  -> placeholder Kidify image
     *  - absolute URL (http://..., https://...) -> returned as-is
     *  - leading slash (e.g. /kidify/...)       -> asset(...) for Kidify static files
     *  - otherwise (e.g. products/xyz.jpg)      -> Storage::disk('public')->url(...)
     */
    function media_url(?string $path, ?string $fallback = null): string
    {
        $fallback = $fallback ?: '/kidify/assets/imgs/page/homepage1/product1.png';
        $value = $path ?: $fallback;

        if (preg_match('#^https?://#i', $value)) {
            return $value;
        }

        if (str_starts_with($value, '/')) {
            return asset(ltrim($value, '/'));
        }

        return Storage::disk('public')->url($value);
    }
}

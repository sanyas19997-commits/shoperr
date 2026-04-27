@php
    /** @var \App\Models\Product $product */
    $imgIndex = ($product->id % 16) + 1;
    $fallbackImg = asset('kidify/assets/imgs/page/homepage1/product' . $imgIndex . '.png');
    $hoverIndex = (($product->id + 5) % 16) + 1;
    $fallbackHover = asset('kidify/assets/imgs/page/homepage1/product' . $hoverIndex . '.png');
    $mainImg = $product->main_image
        ? (\Illuminate\Support\Str::startsWith($product->main_image, ['http', '/']) ? $product->main_image : asset('storage/' . $product->main_image))
        : $fallbackImg;
@endphp
<div class="cardProduct wow fadeInUp">
    <div class="cardImage">
        @if ($product->on_sale)
            <label class="lbl-hot">-{{ $product->discount_percent }}%</label>
        @elseif ($product->is_new ?? false)
            <label class="lbl-hot">new</label>
        @endif
        <a href="{{ route('product.show', $product->slug) }}">
            <img class="imageMain" src="{{ $mainImg }}" alt="{{ $product->name }}" loading="lazy">
            <img class="imageHover" src="{{ $fallbackHover }}" alt="{{ $product->name }}" loading="lazy">
        </a>
        <div class="button-select">
            <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form" style="display:inline;">
                @csrf
                <button type="submit" style="border:0;background:transparent;color:inherit;width:100%;font:inherit;">В корзину</button>
            </form>
        </div>
        <div class="box-quick-button">
            <a class="btn" href="{{ route('product.show', $product->slug) }}" aria-label="Подробнее">
                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </a>
            <a class="btn" href="{{ route('product.show', $product->slug) }}" aria-label="В избранное">
                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="cardInfo">
        <a href="{{ route('product.show', $product->slug) }}">
            <h6 class="font-md-bold cardTitle">{{ $product->name }}</h6>
        </a>
        @if ($product->category)
            <a href="{{ route('catalog.category', $product->category->slug) }}">
                <p class="font-sm cardDesc">{{ $product->category->name }}</p>
            </a>
        @endif
        <div class="cardPrice">
            <h3 class="font-lg-bold neutral-900">{{ number_format($product->current_price, 0, ',', ' ') }} ₽</h3>
            @if ($product->on_sale)
                <h6 class="font-md-line-through neutral-500"><del>{{ number_format($product->price, 0, ',', ' ') }} ₽</del></h6>
            @endif
        </div>
    </div>
</div>

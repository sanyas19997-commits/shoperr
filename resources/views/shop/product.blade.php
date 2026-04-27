@extends('layouts.app')

@section('title', $product->name.' — '.($siteSettings['site_name'] ?? 'Billaro Store'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160))

@php
    $images = $product->images && $product->images->count()
        ? $product->images
        : collect([(object) ['path' => $product->main_image ?: '/kidify/assets/imgs/page/homepage1/product1.png', 'alt' => $product->name]]);
    $main = $images->first();
    $hasSale = $product->sale_price && $product->sale_price > 0 && $product->sale_price < $product->price;
    $price = $hasSale ? $product->sale_price : $product->price;
    $discount = $hasSale ? round(100 - ($product->sale_price / max(0.01, $product->price)) * 100) : 0;
@endphp

@section('content')
<div class="section block-shop-head-2 block-breadcrumb-type-1">
    <div class="container">
        <div class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">Главная</a></li>
                <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                @if($product->category)
                    <li><a href="{{ route('catalog.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                @endif
                <li><span>{{ $product->name }}</span></li>
            </ul>
        </div>
    </div>
</div>

<section class="section block-product-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 box-images-product-left">
                <div class="detail-gallery">
                    <div class="slider-nav-thumbnails">
                        @foreach($images as $img)
                            <div>
                                <div class="item-thumb"><img src="{{ media_url($img->path) }}" alt="{{ $img->alt ?? $product->name }}"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="box-main-gallery">
                        <a class="zoom-image glightbox" href="{{ media_url($main->path) }}" aria-label="Увеличить"></a>
                        <div class="product-image-slider">
                            @foreach($images as $img)
                                <figure class="border-radius-10">
                                    <a class="glightbox" href="{{ media_url($img->path) }}">
                                        <img src="{{ media_url($img->path) }}" alt="{{ $img->alt ?? $product->name }}">
                                    </a>
                                </figure>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 box-images-product-middle">
                <div class="box-product-info">
                    @if($hasSale)
                        <label class="flash-sale-red">−{{ $discount }}%</label>
                    @elseif($product->is_featured)
                        <label class="flash-sale-red" style="background:#FF782D;">Хит продаж</label>
                    @endif
                    <h2 class="font-2xl-bold">{{ $product->name }}</h2>
                    @if($product->sku)
                        <p class="font-md neutral-500 mt-5">Артикул: {{ $product->sku }}</p>
                    @endif
                    <div class="block-price mt-15">
                        <span class="price-main">{{ number_format($price, 0, ',', ' ') }} ₽</span>
                        @if($hasSale)
                            <span class="price-line">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        @endif
                    </div>
                    <div class="block-stock mt-15">
                        @if(($product->stock ?? 0) > 0)
                            <span class="font-md neutral-700">В наличии: <strong class="success-color">{{ $product->stock }} шт</strong></span>
                        @else
                            <span class="font-md neutral-700">Нет в наличии</span>
                        @endif
                    </div>

                    @if($product->short_description)
                        <p class="font-md neutral-700 mt-15">{{ $product->short_description }}</p>
                    @endif

                    <div class="block-buy-product mt-20">
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="add-to-cart-form d-flex align-items-center" style="gap:15px;flex-wrap:wrap;">
                            @csrf
                            <div class="box-quantity">
                                <div class="input-quantity">
                                    <button class="btn btn-decrement btn-quantity" type="button" aria-label="Уменьшить">−</button>
                                    <input class="form-control input-quantity-product" type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock ?? 99) }}">
                                    <button class="btn btn-increment btn-quantity" type="button" aria-label="Увеличить">+</button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-buy-3" {{ ($product->stock ?? 0) > 0 ? '' : 'disabled' }}>
                                <svg class="icon-16 mr-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 0 2.121-.745 2.43-1.822l1.21-4.225a1.5 1.5 0 00-1.43-1.953H5.106M7.5 14.25L5.106 5.25"></path></svg>
                                В корзину
                            </button>
                            <a href="#" class="btn btn-line-bottom-3" aria-label="В избранное">
                                <svg class="icon-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path></svg>
                            </a>
                        </form>
                    </div>

                    <div class="block-product-meta mt-20">
                        @if($product->category)
                            <p class="font-sm neutral-700"><span class="neutral-500">Категория:</span> <a href="{{ route('catalog.category', $product->category->slug) }}">{{ $product->category->name }}</a></p>
                        @endif
                        <p class="font-sm neutral-700"><span class="neutral-500">Поделиться:</span>
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" target="_blank" rel="noopener">Telegram</a> ·
                            <a href="https://vk.com/share.php?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener">VK</a> ·
                            <a href="https://wa.me/?text={{ urlencode($product->name.' '.url()->current()) }}" target="_blank" rel="noopener">WhatsApp</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section block-product-tab">
    <div class="container">
        <ul class="nav-tabs nav-tab-product" role="tablist">
            <li role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Описание</button>
            </li>
            <li role="presentation">
                <button class="nav-link" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery" type="button" role="tab" aria-controls="delivery" aria-selected="false">Доставка и оплата</button>
            </li>
            <li role="presentation">
                <button class="nav-link" id="returns-tab" data-bs-toggle="tab" data-bs-target="#returns" type="button" role="tab" aria-controls="returns" aria-selected="false">Возврат</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="font-md neutral-700 mt-30">
                    @if($product->description)
                        {!! nl2br(e($product->description)) !!}
                    @else
                        <p>Описание будет добавлено в ближайшее время.</p>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                <div class="font-md neutral-700 mt-30">
                    <p>Доставка по всей России курьерскими службами и Почтой России. Срок доставки 3–10 дней в зависимости от региона.</p>
                    <p>Оплата картой онлайн или наличными при получении.</p>
                </div>
            </div>
            <div class="tab-pane fade" id="returns" role="tabpanel" aria-labelledby="returns-tab">
                <div class="font-md neutral-700 mt-30">
                    <p>Возврат в течение 14 дней с момента получения товара. Подробности на странице <a href="{{ route('about') }}">О магазине</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@if($related->count())
<section class="section block-section-related">
    <div class="container">
        <h3 class="font-2xl-bold mb-30">Похожие товары</h3>
        <div class="row">
            @foreach($related as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                    @include('partials.product-card')
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
// Quantity +/- buttons
document.querySelectorAll('.add-to-cart-form').forEach(function (form) {
    var input = form.querySelector('.input-quantity-product');
    if (!input) return;
    var dec = form.querySelector('.btn-decrement');
    var inc = form.querySelector('.btn-increment');
    var min = parseInt(input.getAttribute('min') || '1', 10);
    var max = parseInt(input.getAttribute('max') || '99', 10);
    if (dec) dec.addEventListener('click', function () {
        var v = parseInt(input.value || min, 10);
        if (v > min) input.value = v - 1;
    });
    if (inc) inc.addEventListener('click', function () {
        var v = parseInt(input.value || min, 10);
        if (v < max) input.value = v + 1;
    });
});
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', $product->name.' — '.($siteSettings['site_name'] ?? 'Billaro Store'))
@section('meta_description', $product->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($product->description ?? $product->name), 160))

@section('content')
@php
    $images = $product->images->isNotEmpty() ? $product->images->pluck('path')->all() : [$product->main_image ?? '/kidify/assets/imgs/page/product/img-2.png'];
    $hasSale = $product->sale_price && $product->sale_price > 0 && $product->sale_price < $product->price;
    $price = $hasSale ? $product->sale_price : $product->price;
@endphp
<div class="section block-shop-head-2 block-breadcrumb-type-1">
    <div class="container">
        <div class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">Главная</a></li>
                <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                @if($product->category)
                    <li><a href="{{ route('catalog.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                @endif
                <li>{{ $product->name }}</li>
            </ul>
        </div>
    </div>
</div>

<section class="section block-product-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 box-images-product-left">
                <div class="detail-gallery">
                    @if(count($images) > 1)
                        <div class="slider-nav-thumbnails">
                            @foreach($images as $img)
                                <div><div class="item-thumb"><img src="{{ asset($img) }}" alt="{{ $product->name }}"></div></div>
                            @endforeach
                        </div>
                    @endif
                    <div class="box-main-gallery">
                        <a class="zoom-image glightbox" href="{{ asset($images[0]) }}"></a>
                        <div class="product-image-slider">
                            @foreach($images as $img)
                                <figure class="border-radius-10">
                                    <a class="glightbox" href="{{ asset($img) }}"><img src="{{ asset($img) }}" alt="{{ $product->name }}"></a>
                                </figure>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 box-images-product-middle">
                <div class="box-product-info">
                    @if($hasSale)
                        @php $pct = round((1 - $product->sale_price / $product->price) * 100); @endphp
                        <label class="flash-sale-red">−{{ $pct }}%</label>
                    @endif
                    <h2 class="font-2xl-bold">{{ $product->name }}</h2>
                    <div class="block-rating">
                        @for($i=0; $i<5; $i++)
                            <img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="звезда">
                        @endfor
                        <span class="font-md neutral-500">@if($product->sku) Артикул: {{ $product->sku }} @endif</span>
                    </div>
                    <div class="block-price">
                        <span class="price-main">{{ number_format($price, 0, ',', ' ') }} ₽</span>
                        @if($hasSale)
                            <span class="price-line">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        @endif
                    </div>
                    <div class="block-view">
                        <p class="font-md neutral-900">{!! nl2br(e(\Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 400))) !!}</p>
                    </div>
                    <div class="block-quantity-cart mt-30">
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="add-to-cart-form d-flex align-items-center" style="gap:12px;">
                            @csrf
                            <div class="block-quantity">
                                <span class="text-quantity">Кол-во</span>
                                <input type="number" name="quantity" value="1" min="1" max="99" class="form-control" style="width:80px;">
                            </div>
                            <button type="submit" class="btn btn-buy">В корзину<img src="{{ asset('kidify/assets/imgs/template/icons/cart.svg') }}" alt=""></button>
                        </form>
                    </div>
                    <div class="block-info-product mt-30">
                        @if($product->stock_quantity > 0)
                            <p class="text-success font-md-bold">В наличии ({{ $product->stock_quantity }} шт.)</p>
                        @else
                            <p class="text-warning font-md-bold">Уточняйте наличие</p>
                        @endif
                        @if($product->category)
                            <p class="font-sm neutral-500 mt-10">Категория: <a href="{{ route('catalog.category', $product->category->slug) }}">{{ $product->category->name }}</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-50">
            <div class="col-lg-12">
                <ul class="nav-tabs nav-tab-product" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-selected="true">Описание</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery" type="button" role="tab" aria-selected="false">Доставка и оплата</button></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="block-description-tab pt-30">
                            {!! nl2br(e($product->description ?? '')) !!}
                            @if(empty($product->description))
                                <p class="font-md neutral-700">Подробное описание товара уточняйте у менеджера.</p>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                        <div class="pt-30">
                            <p class="font-md neutral-700">Доставим заказ по всей России. Курьер по Москве — от 350 ₽, ПВЗ СДЭК — от 250 ₽. Возможен самовывоз. Оплата картой онлайн, СБП или при получении.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($related->isNotEmpty())
    <section class="section block-section-5">
        <div class="container">
            <div class="head-tabs mb-30">
                <h3 class="font-2xl-bold neutral-900">Похожие товары</h3>
            </div>
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
@endsection

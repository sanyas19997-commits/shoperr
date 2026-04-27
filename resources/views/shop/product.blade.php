@extends('layouts.shop')

@section('title', $product->name . ' — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    @php
        $imgIndex = ($product->id % 16) + 1;
        $fallbackImg = asset('kidify/assets/imgs/page/homepage1/product' . $imgIndex . '.png');
        $mainImg = $product->main_image
            ? (\Illuminate\Support\Str::startsWith($product->main_image, ['http', '/']) ? $product->main_image : asset('storage/' . $product->main_image))
            : $fallbackImg;
        $allImages = $product->images->isNotEmpty()
            ? $product->images->map(fn($img) => asset('storage/' . $img->path))->all()
            : [$mainImg, asset('kidify/assets/imgs/page/homepage1/product' . ((($product->id+3) % 16) + 1) . '.png'), asset('kidify/assets/imgs/page/homepage1/product' . ((($product->id+7) % 16) + 1) . '.png')];
    @endphp

    <section class="section box-section-shop-page">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">{{ $product->name }}</h2>
                <ul class="breadcrumb">
                    <li><a class="font-sm" href="{{ route('home') }}">Главная</a></li>
                    <li><a class="font-sm" href="{{ route('catalog.index') }}">Каталог</a></li>
                    @if ($product->category)
                        <li><a class="font-sm" href="{{ route('catalog.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                    @endif
                    <li><a class="font-sm" href="#">{{ $product->name }}</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30">
            <div class="box-product-detail">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="gallery-image">
                            <div class="galleryProductSingle" style="background:#FFF6EC;border-radius:14px;padding:30px;text-align:center;">
                                <img id="product-main-image" src="{{ $mainImg }}" alt="{{ $product->name }}" style="width:100%;max-width:480px;height:auto;border-radius:10px;">
                            </div>
                            <div class="d-flex flex-wrap mt-15" style="gap:10px;">
                                @foreach ($allImages as $imgUrl)
                                    <img class="thumb" src="{{ $imgUrl }}" alt="{{ $product->name }}"
                                         style="width:80px;height:80px;object-fit:cover;border-radius:8px;cursor:pointer;border:2px solid {{ $loop->first ? '#FF6E30' : '#eee' }};padding:5px;background:#fff;"
                                         onclick="document.getElementById('product-main-image').src=this.src;document.querySelectorAll('.thumb').forEach(t=>t.style.borderColor='#eee');this.style.borderColor='#FF6E30';">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="info-product-detail pl-15">
                            @if ($product->category)
                                <p class="font-sm neutral-500 mb-5">
                                    <a href="{{ route('catalog.category', $product->category->slug) }}" style="color:#FF6E30;">{{ $product->category->name }}</a>
                                </p>
                            @endif
                            <h2 class="font-3xl-bold color-brand-3 mb-15">{{ $product->name }}</h2>

                            @if ($product->sku)
                                <p class="font-sm neutral-500 mb-10">Артикул: <strong>{{ $product->sku }}</strong></p>
                            @endif

                            <div class="rating mb-15">
                                <span style="color:#FFC107;">★★★★★</span>
                                <span class="font-sm neutral-500 ml-5">(Отзывы скоро)</span>
                            </div>

                            <div class="price-product mb-20">
                                <h3 class="d-inline-block font-3xl-bold color-brand-3 mr-10" style="font-size:36px;">
                                    {{ number_format($product->current_price, 0, ',', ' ') }} ₽
                                </h3>
                                @if ($product->on_sale)
                                    <h5 class="d-inline-block neutral-500" style="text-decoration:line-through;font-size:20px;">
                                        {{ number_format($product->price, 0, ',', ' ') }} ₽
                                    </h5>
                                    <span class="lbl-hot ml-10" style="background:#FF4D4F;color:#fff;padding:4px 12px;border-radius:6px;font-size:14px;">
                                        -{{ $product->discount_percent }}%
                                    </span>
                                @endif
                            </div>

                            @if ($product->short_description)
                                <p class="font-md neutral-700 mb-20">{{ $product->short_description }}</p>
                            @endif

                            <div class="mb-20">
                                @if ($product->stock > 0)
                                    <p class="font-sm" style="color:#4CAF50;">✓ В наличии: <strong>{{ $product->stock }} шт.</strong></p>
                                @else
                                    <p class="font-sm" style="color:#FF4D4F;">✗ Нет в наличии</p>
                                @endif
                            </div>

                            <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form box-buy-product">
                                @csrf
                                <div class="d-flex align-items-center mb-15" style="gap:15px;flex-wrap:wrap;">
                                    <div class="quantity-input d-flex align-items-center" style="border:1px solid #ddd;border-radius:6px;background:#fff;">
                                        <button type="button" onclick="var i=document.getElementById('qty-input');i.value=Math.max(1,parseInt(i.value)-1);" style="border:0;background:transparent;width:40px;height:44px;font-size:18px;">−</button>
                                        <input type="number" id="qty-input" name="quantity" value="1" min="1" max="{{ $product->stock ?: 99 }}" style="width:60px;border:0;text-align:center;font-weight:600;background:transparent;">
                                        <button type="button" onclick="var i=document.getElementById('qty-input');i.value=Math.min({{ $product->stock ?: 99 }},parseInt(i.value)+1);" style="border:0;background:transparent;width:40px;height:44px;font-size:18px;">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-brand-3" style="padding:12px 32px;" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        В корзину
                                    </button>
                                    <a href="#" class="btn btn-default" style="padding:12px 24px;">♡ В избранное</a>
                                </div>
                            </form>

                            <div class="border-top pt-20 mt-15">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="font-sm neutral-700 mb-10">🚚 <strong>Быстрая доставка</strong> по всей России</p>
                                        <p class="font-sm neutral-700 mb-0">↩️ <strong>Возврат</strong> в течение 14 дней</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="font-sm neutral-700 mb-10">🔒 <strong>Безопасная оплата</strong> онлайн</p>
                                        <p class="font-sm neutral-700 mb-0">⭐ <strong>Гарантия</strong> качества</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs: Description / Specifications / Reviews --}}
            <div class="box-product-tabs mt-50">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Описание</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">Характеристики</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Отзывы</button>
                    </li>
                </ul>
                <div class="tab-content mt-20">
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        @if ($product->description)
                            <div class="font-md neutral-900">{!! nl2br(e($product->description)) !!}</div>
                        @else
                            <p class="font-md neutral-700">{{ $product->short_description ?? 'Описание появится в ближайшее время.' }}</p>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="specifications" role="tabpanel">
                        <table class="table">
                            <tbody>
                                @if ($product->sku)<tr><th style="width:30%;">Артикул</th><td>{{ $product->sku }}</td></tr>@endif
                                @if ($product->category)<tr><th>Категория</th><td>{{ $product->category->name }}</td></tr>@endif
                                <tr><th>Наличие</th><td>{{ $product->stock > 0 ? 'В наличии' : 'Нет в наличии' }}</td></tr>
                                <tr><th>Цена</th><td>{{ number_format($product->current_price, 0, ',', ' ') }} ₽</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <p class="font-md neutral-700">Отзывов пока нет. Станьте первым, кто оставит отзыв на этот товар.</p>
                    </div>
                </div>
            </div>

            {{-- Related products --}}
            @if ($related->isNotEmpty())
                <section class="section block-section-5 mt-50">
                    <div class="top-head">
                        <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn">Похожие товары</h4>
                        <a class="btn btn-arrow-right wow animate__animated animate__fadeIn" href="{{ route('catalog.index') }}">Смотреть все<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt=""></a>
                    </div>
                    <div class="row">
                        @foreach ($related as $r)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                                @include('layouts.partials.product-card', ['product' => $r])
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
@endsection

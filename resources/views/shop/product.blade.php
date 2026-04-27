@extends('layouts.shop')

@section('title', $product->name)

@section('content')
    <section class="section-box shop-template mt-30">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-15">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Каталог</a></li>
                    @if ($product->category)
                        <li class="breadcrumb-item"><a href="{{ route('catalog.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-lg-6 mb-30">
                    <div class="gallery-image">
                        <div class="main-image mb-10" style="background:#fff;border:1px solid #eee;border-radius:14px;padding:20px;">
                            @if ($product->main_image)
                                <img id="product-main-image" src="{{ \Illuminate\Support\Str::startsWith($product->main_image, ['http', '/']) ? $product->main_image : asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" style="width:100%;height:auto;">
                            @else
                                <div id="product-main-image" style="height:380px;background:linear-gradient(135deg,#FFE9D6,#FFC9B0);display:flex;align-items:center;justify-content:center;border-radius:12px;font-size:80px;">🛍️</div>
                            @endif
                        </div>
                        @if ($product->images->isNotEmpty())
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($product->images as $img)
                                    <img class="thumb" src="{{ asset('storage/' . $img->path) }}" alt="{{ $img->alt }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;cursor:pointer;border:1px solid #eee;" onclick="document.getElementById('product-main-image').src=this.src">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 mb-30">
                    @if ($product->category)
                        <p class="font-sm color-gray-500 mb-5"><a href="{{ route('catalog.category', $product->category->slug) }}">{{ $product->category->name }}</a></p>
                    @endif
                    <h1 class="font-xxl-bold color-brand-3 mb-15">{{ $product->name }}</h1>
                    @if ($product->sku)
                        <p class="font-sm color-gray-500 mb-10">Артикул: {{ $product->sku }}</p>
                    @endif

                    <div class="mb-20" style="font-size:28px;">
                        <strong class="color-brand-3">{{ number_format($product->current_price, 0, ',', ' ') }} ₽</strong>
                        @if ($product->on_sale)
                            <span class="color-gray-500 ml-10" style="font-size:18px;"><del>{{ number_format($product->price, 0, ',', ' ') }} ₽</del></span>
                            <span class="badge bg-danger ml-10">-{{ $product->discount_percent }}%</span>
                        @endif
                    </div>

                    @if ($product->stock > 0)
                        <p class="text-success mb-15">✓ В наличии: {{ $product->stock }} шт.</p>
                    @else
                        <p class="text-danger mb-15">✗ Нет в наличии</p>
                    @endif

                    @if ($product->short_description)
                        <p class="font-md mb-20">{{ $product->short_description }}</p>
                    @endif

                    <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form mb-20">
                        @csrf
                        <div class="d-flex align-items-center gap-2 flex-wrap" style="gap:10px;">
                            <div class="d-flex align-items-center" style="border:1px solid #ddd;border-radius:6px;">
                                <button type="button" class="btn" onclick="var i=document.getElementById('qty-input');i.value=Math.max(1,parseInt(i.value)-1);">−</button>
                                <input type="number" id="qty-input" name="quantity" value="1" min="1" max="99" style="width:60px;border:0;text-align:center;">
                                <button type="button" class="btn" onclick="var i=document.getElementById('qty-input');i.value=Math.min(99,parseInt(i.value)+1);">+</button>
                            </div>
                            <button type="submit" class="btn btn-buy" {{ $product->stock <= 0 ? 'disabled' : '' }}>В корзину</button>
                        </div>
                    </form>

                    <div class="border-top pt-20">
                        <p class="font-sm color-gray-700 mb-5">🚚 Доставка по всей России</p>
                        <p class="font-sm color-gray-700 mb-5">↩️ Возврат в течение 14 дней</p>
                        <p class="font-sm color-gray-700 mb-0">🔒 Безопасная оплата</p>
                    </div>
                </div>
            </div>

            @if ($product->description)
                <div class="row mt-30">
                    <div class="col-12">
                        <h3 class="font-xl-bold mb-15">Описание</h3>
                        <div class="font-md color-gray-900">{!! nl2br(e($product->description)) !!}</div>
                    </div>
                </div>
            @endif

            @if ($related->isNotEmpty())
                <div class="mt-50">
                    <h3 class="font-xl-bold mb-20">Похожие товары</h3>
                    <div class="row">
                        @foreach ($related as $r)
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                                @include('layouts.partials.product-card', ['product' => $r])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

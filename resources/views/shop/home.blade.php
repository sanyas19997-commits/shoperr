@extends('layouts.shop')

@section('title', \App\Models\Setting::get('site_name', 'Billaro Store') . ' — Интернет-магазин')

@section('content')
    {{-- Hero banner slider --}}
    <section class="section banner-homepage1">
        <div class="container">
            <div class="box-swiper">
                <div class="swiper-container swiper-banner pb-0">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="box-banner-home1">
                                <div class="box-cover-image wow animate__animated animate__fadeInLeft" style="background-image:url({{ asset('kidify/assets/imgs/page/homepage1/banner.png') }});background-size:cover;background-position:center;"></div>
                                <div class="box-banner-info">
                                    <div class="block-info-banner">
                                        <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Сезонные</p>
                                        <h2 class="heading-banner mb-10 wow animate__animated animate__zoomIn">
                                            <span class="text-up">скидки</span>
                                            <span class="text-under">скидки</span>
                                        </h2>
                                        <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">{{ \App\Models\Setting::get('hero_title', 'Качественные товары для всей семьи') }}</h4>
                                        <div class="text-center mt-10">
                                            <a class="btn btn-double-border wow animate__animated animate__zoomIn" href="{{ route('catalog.index') }}"><span>Все предложения</span></a>
                                            <a class="btn btn-arrow-right wow animate__animated animate__zoomIn" href="{{ route('about') }}">О нас<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box-banner-home1">
                                <div class="box-cover-image wow animate__animated animate__fadeInLeft" style="background-image:url({{ asset('kidify/assets/imgs/page/homepage1/banner2.png') }});background-size:cover;background-position:center;"></div>
                                <div class="box-banner-info wow animate__animated animate__zoomIn">
                                    <div class="block-info-banner">
                                        <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Новая</p>
                                        <h2 class="heading-banner mb-10 wow animate__animated animate__zoomIn">
                                            <span class="text-up">коллекция</span>
                                            <span class="text-under">коллекция</span>
                                        </h2>
                                        <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">{{ \App\Models\Setting::get('hero_subtitle', 'Большой выбор, выгодные цены и быстрая доставка по всей России.') }}</h4>
                                        <div class="text-center mt-10">
                                            <a class="btn btn-double-border wow animate__animated animate__zoomIn" href="{{ route('catalog.index') }}"><span>В каталог</span></a>
                                            <a class="btn btn-arrow-right wow animate__animated animate__zoomIn" href="{{ route('contact') }}">Контакты<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-pagination-button">
                        <div class="swiper-pagination swiper-pagination-banner"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories slider --}}
    @if ($categories->isNotEmpty())
        <div class="section block-section block-section-categories-slider wow animate__animated animate__fadeIn">
            <div class="container">
                <div class="box-swiper">
                    <div class="swiper-container swiper-9-items pb-0">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $i => $cat)
                                @php $iconNum = ($i % 8) + 1; @endphp
                                <div class="swiper-slide">
                                    <div class="cardCategory">
                                        <div class="cardImage">
                                            <a href="{{ route('catalog.category', $cat->slug) }}">
                                                @if ($cat->image)
                                                    <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}">
                                                @else
                                                    <img src="{{ asset('kidify/assets/imgs/page/homepage3/cat' . ($iconNum == 1 ? '' : $iconNum) . '.png') }}" alt="{{ $cat->name }}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="cardInfo"><a href="{{ route('catalog.category', $cat->slug) }}">{{ $cat->name }}</a></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- New in store - product tabs --}}
    @if ($featured->isNotEmpty() || $newest->isNotEmpty())
        <section class="section block-section-1">
            <div class="container">
                <div class="text-center">
                    <p class="font-xl brand-2 wow animate__animated animate__fadeIn"><span class="rounded-text">НОВОЕ В МАГАЗИНЕ</span></p>
                    <div class="box-tabs wow animate__animated animate__fadeIn">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured" type="button" role="tab" aria-selected="true">Хиты продаж</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-selected="false">Новинки</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sale-tab" data-bs-toggle="tab" data-bs-target="#sale" type="button" role="tab" aria-selected="false">Со скидкой</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="featured" role="tabpanel">
                        <div class="row">
                            @foreach ($featured as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    @include('layouts.partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="newest" role="tabpanel">
                        <div class="row">
                            @foreach ($newest as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    @include('layouts.partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sale" role="tabpanel">
                        <div class="row">
                            @foreach ($onSale as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    @include('layouts.partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="text-center mt-30">
                    <a class="btn btn-brand-3" href="{{ route('catalog.index') }}">Смотреть все товары</a>
                </div>
            </div>
        </section>
    @endif

    {{-- Promo banner --}}
    <section class="section block-section-2">
        <div class="container">
            <div class="box-info-section2">
                <h2 class="heading-banner mb-25 wow animate__animated animate__bounceIn">
                    <span class="text-up">{{ \App\Models\Setting::get('promo_title', 'Спецпредложение') }}</span>
                    <span class="text-under">{{ \App\Models\Setting::get('promo_title', 'Спецпредложение') }}</span>
                </h2>
                <p class="font-3xl-bold neutral-900 mb-35 wow animate__animated animate__fadeIn">{{ \App\Models\Setting::get('promo_text', 'Скидки на популярные категории. Успей купить по выгодной цене!') }}</p>
                <a class="btn btn-brand-3" href="{{ route('catalog.index') }}">В магазин</a>
            </div>
            <div class="block-section-img wow animate__animated animate__fadeIn"><img src="{{ asset('kidify/assets/imgs/page/homepage1/bg-section2.png') }}" alt="{{ \App\Models\Setting::get('site_name', 'Billaro Store') }}"></div>
        </div>
    </section>

    {{-- Two collections banner --}}
    @if ($categories->count() >= 2)
        <section class="section block-section-4">
            <div class="container">
                <div class="box-section-4">
                    <div class="row">
                        @foreach ($categories->take(2) as $idx => $promoCat)
                            <div class="col-lg-6">
                                <div class="box-collection {{ $idx === 1 ? 'box-collection-2' : '' }} wow animate__animated animate__fadeIn">
                                    <div class="box-collection-info">
                                        <h4 class="heading-4 mb-15">{{ $promoCat->name }}</h4>
                                        <p class="font-md neutral-900 mb-35">{{ $promoCat->description ? \Illuminate\Support\Str::limit(strip_tags($promoCat->description), 100) : 'Скидки до 35% на товары этой категории. Успей купить!' }}</p>
                                        <a class="btn btn-brand-1 text-uppercase" href="{{ route('catalog.category', $promoCat->slug) }}">Перейти</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Popular products --}}
    @if ($popular->isNotEmpty())
        <section class="section block-section-5">
            <div class="container">
                <div class="top-head">
                    <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn">Популярные товары</h4>
                    <a class="btn btn-arrow-right wow animate__animated animate__fadeIn" href="{{ route('catalog.index') }}">Смотреть все<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt=""></a>
                </div>
                <div class="row">
                    @foreach ($popular as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30 wow animate__animated animate__fadeIn">
                            @include('layouts.partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Why choose us / features --}}
    <section class="section block-section-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center wow animate__animated animate__fadeIn">
                    <div style="font-size:48px;">🚚</div>
                    <h5 class="mt-15 mb-10">Быстрая доставка</h5>
                    <p class="font-sm neutral-700">Доставим заказ по всей России курьером или в ПВЗ от 1 дня</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center wow animate__animated animate__fadeIn">
                    <div style="font-size:48px;">🔒</div>
                    <h5 class="mt-15 mb-10">Безопасная оплата</h5>
                    <p class="font-sm neutral-700">Картой онлайн, СБП или при получении — выбирайте удобный способ</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center wow animate__animated animate__fadeIn">
                    <div style="font-size:48px;">↩️</div>
                    <h5 class="mt-15 mb-10">Возврат 14 дней</h5>
                    <p class="font-sm neutral-700">Без лишних вопросов в течение 14 дней с момента получения</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center wow animate__animated animate__fadeIn">
                    <div style="font-size:48px;">⭐</div>
                    <h5 class="mt-15 mb-10">Гарантия качества</h5>
                    <p class="font-sm neutral-700">Только проверенные бренды и сертифицированные товары</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Newsletter --}}
    <section class="section block-section-10 mb-50">
        <div class="container">
            <div class="box-newsletter" style="background:#FFF5E1;border-radius:20px;padding:40px;text-align:center;">
                <h3 class="font-xxl-bold neutral-900 mb-10">Подпишитесь на рассылку</h3>
                <p class="font-md neutral-700 mb-25">Узнавайте первыми о скидках, новинках и спецпредложениях</p>
                <form action="{{ route('contact.submit') }}" method="POST" class="d-flex justify-content-center" style="max-width:500px;margin:0 auto;gap:10px;">
                    @csrf
                    <input type="hidden" name="subject" value="Подписка на рассылку">
                    <input type="hidden" name="message" value="Подписка на рассылку с главной страницы">
                    <input type="hidden" name="name" value="Подписчик">
                    <input type="email" name="email" class="form-control" placeholder="Введите ваш email" required style="flex:1;padding:12px;border-radius:8px;border:1px solid #ddd;">
                    <button type="submit" class="btn btn-brand-3">Подписаться</button>
                </form>
            </div>
        </div>
    </section>
@endsection

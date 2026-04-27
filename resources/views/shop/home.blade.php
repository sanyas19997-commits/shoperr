@extends('layouts.app')

@section('title', $siteSettings['site_name'] ?? 'Billaro Store - Магазин детских товаров')

@section('content')
<section class="section banner-homepage1">
    <div class="container">
        <div class="box-swiper">
            <div class="swiper-container swiper-banner pb-0">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="box-banner-home1">
                            <div class="box-cover-image wow animate__animated animate__fadeInLeft" style="background-image:url({{ asset('kidify/assets/imgs/page/homepage1/banner.png') }})"></div>
                            <div class="box-banner-info">
                                <div class="block-sale wow animate__animated animate__fadeInTop"><img src="{{ asset('kidify/assets/imgs/page/homepage1/sale.png') }}" alt="Billaro Store"></div>
                                <div class="blockleaf rotateme"><img src="{{ asset('kidify/assets/imgs/page/homepage1/leaf.png') }}" alt="Billaro Store"></div>
                                <div class="block-info-banner">
                                    <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Зима</p>
                                    <h2 class="heading-banner mb-10 wow animate__animated animate__zoomIn"><span class="text-up">распродажа</span><span class="text-under">распродажа</span></h2>
                                    <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Всё для вашего малыша</h4>
                                    <div class="text-center mt-10">
                                        <a class="btn btn-double-border wow animate__animated animate__zoomIn" href="{{ route('catalog.index') }}"><span>Смотреть скидки</span></a>
                                        <a class="btn btn-arrow-right wow animate__animated animate__zoomIn" href="{{ route('about') }}">Подробнее<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="→"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="box-banner-home1">
                            <div class="box-cover-image wow animate__animated animate__fadeInLeft" style="background-image:url({{ asset('kidify/assets/imgs/page/homepage1/banner2.png') }})"></div>
                            <div class="box-banner-info">
                                <div class="block-sale wow animate__animated animate__fadeInTop"><img src="{{ asset('kidify/assets/imgs/page/homepage1/sale.png') }}" alt="Billaro Store"></div>
                                <div class="blockleaf rotateme"><img src="{{ asset('kidify/assets/imgs/page/homepage1/star.png') }}" alt="Billaro Store"></div>
                                <div class="block-info-banner">
                                    <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Новая</p>
                                    <h2 class="heading-banner mb-10 wow animate__animated animate__zoomIn"><span class="text-up">коллекция</span><span class="text-under">коллекция</span></h2>
                                    <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Качественные товары для всей семьи</h4>
                                    <div class="text-center mt-10">
                                        <a class="btn btn-double-border wow animate__animated animate__zoomIn" href="{{ route('catalog.index') }}"><span>В каталог</span></a>
                                        <a class="btn btn-arrow-right wow animate__animated animate__zoomIn" href="{{ route('contact') }}">Контакты<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="→"></a>
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

<div class="section block-section block-section-categories-slider wow animate__animated animate__fadeIn">
    <div class="container">
        <div class="box-swiper">
            <div class="swiper-container swiper-9-items pb-0">
                <div class="swiper-wrapper">
                    @foreach($categories as $i => $cat)
                        <div class="swiper-slide">
                            <div class="cardCategory">
                                <div class="cardImage">
                                    <a href="{{ route('catalog.category', $cat->slug) }}">
                                        @php $img = $cat->image ?: '/kidify/assets/imgs/page/homepage3/cat'.($i ? $i+1 : '').'.png'; @endphp
                                        <img src="{{ asset($img) }}" alt="{{ $cat->name }}">
                                    </a>
                                </div>
                                <div class="cardInfo"><a href="{{ route('catalog.category', $cat->slug) }}">{{ $cat->name }}</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination swiper-pagination-9-items"></div>
            </div>
        </div>
    </div>
</div>

<section class="section block-section-1">
    <div class="container">
        <div class="box-tab-product">
            <div class="head-tabs">
                <h2 class="font-2xl-bold neutral-900 mb-15 wow animate__animated animate__fadeIn">Новое в магазине</h2>
                <ul class="nav nav-tabs nav-tabs-product" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured" type="button" role="tab" aria-controls="featured" aria-selected="true">Хиты продаж</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-controls="newest" aria-selected="false">Новинки</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="onsale-tab" data-bs-toggle="tab" data-bs-target="#onsale" type="button" role="tab" aria-controls="onsale" aria-selected="false">Со скидкой</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="featured" role="tabpanel" aria-labelledby="featured-tab">
                    <div class="row">
                        @foreach($featured as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                @include('partials.product-card')
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="newest" role="tabpanel" aria-labelledby="newest-tab">
                    <div class="row">
                        @foreach($newest as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                @include('partials.product-card')
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="onsale" role="tabpanel" aria-labelledby="onsale-tab">
                    <div class="row">
                        @if($onSale->isEmpty())
                            <div class="col-12 text-center"><p class="font-md neutral-500 py-5">Сейчас нет товаров со скидкой</p></div>
                        @else
                            @foreach($onSale as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    @include('partials.product-card')
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-center mt-30">
                <a class="btn btn-line-bottom-3 wow animate__animated animate__fadeIn" href="{{ route('catalog.index') }}">Смотреть все товары<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="→"></a>
            </div>
        </div>
    </div>
</section>

<section class="section block-section-2">
    <div class="container">
        <div class="box-cover-banner-1 wow animate__animated animate__fadeIn">
            <div class="cover-banner-1" style="background-image:url({{ asset('kidify/assets/imgs/page/homepage1/bg-section2.png') }})"></div>
            <div class="info-banner-1">
                <h2 class="heading-banner mb-15 wow animate__animated animate__zoomIn"><span class="text-up">{{ $promo['title'] ?? 'Спецпредложение' }}</span><span class="text-under">{{ $promo['title'] ?? 'Спецпредложение' }}</span></h2>
                <h4 class="heading-4 mb-30 wow animate__animated animate__zoomIn">{{ $promo['text'] ?? 'Скидки на популярные категории. Успей купить по выгодной цене!' }}</h4>
                <div class="mt-10"><a class="btn btn-double-border wow animate__animated animate__zoomIn" href="{{ route('catalog.index') }}"><span>В магазин</span></a></div>
            </div>
        </div>
    </div>
</section>

<section class="section block-section-3">
    <div class="container">
        <div class="row">
            @foreach($categories->take(2) as $cat)
                <div class="col-lg-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                    <div class="banner-cat-1">
                        <div class="banner-cat-1-info">
                            <h4 class="font-3xl-bold neutral-900 mb-15">{{ $cat->name }}</h4>
                            <p class="font-md neutral-700 mb-30">Скидки до 35% на товары этой категории. Успей купить!</p>
                            <a class="btn btn-arrow-right" href="{{ route('catalog.category', $cat->slug) }}">Перейти<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="→"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section block-section-5">
    <div class="container">
        <div class="head-tabs mb-30">
            <h2 class="font-2xl-bold neutral-900 wow animate__animated animate__fadeIn">Популярные товары</h2>
            <a class="font-md-bold neutral-900" href="{{ route('catalog.index') }}">Смотреть все<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="→"></a>
        </div>
        <div class="row">
            @foreach($popular as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                    @include('partials.product-card')
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section block-section-6">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                <div class="card-feature text-center">
                    <div class="card-icon mb-15"><img src="{{ asset('kidify/assets/imgs/page/homepage1/icon1.svg') }}" alt="Доставка"></div>
                    <h5 class="font-md-bold neutral-900">Быстрая доставка</h5>
                    <p class="font-sm neutral-500 mt-10">Доставим заказ по всей России курьером или в ПВЗ от 1 дня</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                <div class="card-feature text-center">
                    <div class="card-icon mb-15"><img src="{{ asset('kidify/assets/imgs/page/homepage1/icon2.svg') }}" alt="Оплата"></div>
                    <h5 class="font-md-bold neutral-900">Безопасная оплата</h5>
                    <p class="font-sm neutral-500 mt-10">Картой онлайн, СБП или при получении — выбирайте удобный способ</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                <div class="card-feature text-center">
                    <div class="card-icon mb-15"><img src="{{ asset('kidify/assets/imgs/page/homepage1/icon3.svg') }}" alt="Возврат"></div>
                    <h5 class="font-md-bold neutral-900">Возврат 14 дней</h5>
                    <p class="font-sm neutral-500 mt-10">Без лишних вопросов в течение 14 дней с момента получения</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                <div class="card-feature text-center">
                    <div class="card-icon mb-15"><img src="{{ asset('kidify/assets/imgs/page/homepage1/icon4.svg') }}" alt="Гарантия"></div>
                    <h5 class="font-md-bold neutral-900">Гарантия качества</h5>
                    <p class="font-sm neutral-500 mt-10">Только проверенные бренды и сертифицированные товары</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section block-section-10">
    <div class="container">
        <div class="box-newsletter-section wow animate__animated animate__fadeIn">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h3 class="heading-3 mb-10">Подпишитесь на новости</h3>
                    <p class="font-md neutral-700">Узнавайте первыми о скидках, новинках и спецпредложениях.</p>
                </div>
                <div class="col-lg-5">
                    <form action="#" class="newsletter-form" onsubmit="event.preventDefault(); this.querySelector('button').textContent = 'Спасибо!';">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Введите ваш email" required>
                            <button type="submit" class="btn btn-buy-3">Подписаться</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

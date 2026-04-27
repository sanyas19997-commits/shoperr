@extends('layouts.shop')

@section('title', 'Главная')

@section('content')
    <section class="section-box box-banner-home2 mt-30">
        <div class="container">
            <div class="banner-hero hero-2">
                <div class="banner-big bg-9 d-flex align-items-center" style="min-height:380px;background:linear-gradient(135deg,#FFF5E1,#FCE3D2) center/cover no-repeat;border-radius:20px;padding:40px;">
                    <div class="banner-big-inner">
                        <h6 class="color-brand-2 mb-10">Добро пожаловать!</h6>
                        <h1 class="color-brand-3 mb-15">{{ \App\Models\Setting::get('hero_title', 'Качественные товары для всей семьи') }}</h1>
                        <p class="font-md color-gray-700 mb-25">{{ \App\Models\Setting::get('hero_subtitle', 'Большой выбор, выгодные цены и быстрая доставка по всей России.') }}</p>
                        <div class="d-flex">
                            <a class="btn btn-buy mr-15" href="{{ route('catalog.index') }}">Перейти в каталог →</a>
                            <a class="btn btn-default" href="{{ route('about') }}">О магазине</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($categories->isNotEmpty())
        <section class="section-box mt-50">
            <div class="container">
                <h2 class="font-xxl-bold color-brand-3 text-center mb-15">Популярные категории</h2>
                <p class="text-center font-md color-gray-700 mb-30">Выберите интересующий вас раздел</p>
                <div class="row">
                    @foreach ($categories as $cat)
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-20">
                            <a href="{{ route('catalog.category', $cat->slug) }}" class="card-grid-category text-center d-block p-20" style="background:#fff;border:1px solid #eee;border-radius:14px;text-decoration:none;color:#0E0E0E;transition:.2s;">
                                @if ($cat->image)
                                    <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" style="max-height:120px;width:auto;">
                                @else
                                    <div style="font-size:48px;">🛍️</div>
                                @endif
                                <h6 class="mt-10 mb-0">{{ $cat->name }}</h6>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($featured->isNotEmpty())
        <section class="section-box mt-50">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-20">
                    <h2 class="font-xxl-bold color-brand-3 mb-0">Хиты продаж</h2>
                    <a class="btn btn-default" href="{{ route('catalog.index') }}">Все товары →</a>
                </div>
                <div class="row">
                    @foreach ($featured as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                            @include('layouts.partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($newest->isNotEmpty())
        <section class="section-box mt-30">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-20">
                    <h2 class="font-xxl-bold color-brand-3 mb-0">Новинки</h2>
                    <a class="btn btn-default" href="{{ route('catalog.index') }}">Все новинки →</a>
                </div>
                <div class="row">
                    @foreach ($newest as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                            @include('layouts.partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section-box mt-60 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 mb-20 text-center"><div style="font-size:40px;">🚚</div><h6 class="mt-10">Быстрая доставка</h6><p class="font-sm color-gray-700">По всей России от 1 дня</p></div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-20 text-center"><div style="font-size:40px;">🔒</div><h6 class="mt-10">Безопасная оплата</h6><p class="font-sm color-gray-700">Картой онлайн или при получении</p></div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-20 text-center"><div style="font-size:40px;">↩️</div><h6 class="mt-10">Возврат 14 дней</h6><p class="font-sm color-gray-700">Без лишних вопросов</p></div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-20 text-center"><div style="font-size:40px;">💬</div><h6 class="mt-10">Поддержка 24/7</h6><p class="font-sm color-gray-700">Всегда на связи</p></div>
            </div>
        </div>
    </section>
@endsection

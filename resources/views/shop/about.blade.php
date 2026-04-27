@extends('layouts.shop')

@section('title', 'О магазине')

@section('content')
    <section class="section-box mt-30 mb-50">
        <div class="container">
            <h1 class="font-xxl-bold color-brand-3 mb-20">О магазине</h1>
            @if ($page && $page->body)
                <div class="font-md color-gray-900">{!! $page->body !!}</div>
            @else
                <p class="font-md color-gray-700">{{ \App\Models\Setting::get('about_text', 'Мы — современный интернет-магазин с широким ассортиментом товаров. Работаем для вас с заботой и любовью к качеству. Доставляем по всей России.') }}</p>

                <div class="row mt-30">
                    <div class="col-md-4 mb-20"><h5 class="font-md-bold">🚚 Быстрая доставка</h5><p class="color-gray-700">Доставляем заказы в любой город России в кратчайшие сроки.</p></div>
                    <div class="col-md-4 mb-20"><h5 class="font-md-bold">💯 Только качество</h5><p class="color-gray-700">Все товары проходят строгий контроль качества.</p></div>
                    <div class="col-md-4 mb-20"><h5 class="font-md-bold">💬 Поддержка 24/7</h5><p class="color-gray-700">Отвечаем на ваши вопросы в любое время.</p></div>
                </div>
            @endif
        </div>
    </section>
@endsection

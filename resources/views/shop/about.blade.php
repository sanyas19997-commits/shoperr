@extends('layouts.app')

@section('title', 'О магазине — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">{{ $page->title ?? 'О магазине' }}</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li>О магазине</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="feature-image">
            <img src="{{ asset('kidify/assets/imgs/page/about/img.png') }}" alt="{{ $siteSettings['site_name'] ?? 'Billaro Store' }}">
        </div>
        <div class="content-detail">
            @if(!empty($page) && !empty($page->body))
                {!! $page->body !!}
            @else
                <h2>Наша история</h2>
                <p><strong>{{ $siteSettings['site_name'] ?? 'Billaro Store' }} — это интернет-магазин товаров для детей и всей семьи.</strong> Мы тщательно отбираем игрушки, одежду, аксессуары и средства для безопасности, чтобы родителям было проще найти всё необходимое в одном месте.</p>
                <p>Сотрудничаем напрямую с проверенными брендами, поэтому можем держать честные цены и быстро доставлять заказы по всей России. Наша команда сама родители — мы знаем, что важно для ребёнка, и подбираем ассортимент так, как покупали бы для собственных детей.</p>

                <ul class="list-ticks">
                    <li><img src="{{ asset('kidify/assets/imgs/page/about/tick.png') }}" alt="">Только проверенные бренды и сертифицированный товар</li>
                    <li><img src="{{ asset('kidify/assets/imgs/page/about/tick.png') }}" alt="">Удобный возврат в течение 14 дней</li>
                    <li><img src="{{ asset('kidify/assets/imgs/page/about/tick.png') }}" alt="">Доставка по всей России от 1 дня</li>
                    <li><img src="{{ asset('kidify/assets/imgs/page/about/tick.png') }}" alt="">Поддержка в чате 7 дней в неделю</li>
                </ul>

                <div class="box-experiences">
                    <div class="row">
                        <div class="col-lg-4">
                            <strong class="font-xl-bold">10 000+</strong>
                            <p class="font-md neutral-500">довольных покупателей по всей стране.</p>
                        </div>
                        <div class="col-lg-4">
                            <strong class="font-xl-bold">5 000+</strong>
                            <p class="font-md neutral-500">товаров в каталоге для разных возрастов.</p>
                        </div>
                        <div class="col-lg-4">
                            <strong class="font-xl-bold">99%</strong>
                            <p class="font-md neutral-500">положительных отзывов о доставке и качестве.</p>
                        </div>
                    </div>
                </div>

                <h2>Что мы предлагаем</h2>
                <p>В нашем каталоге — игрушки, одежда, обувь, аксессуары, товары для безопасности и развития. Если не нашли нужный товар — напишите нам в чат, поможем подобрать аналог или закажем напрямую от производителя.</p>

                <p class="mt-30 text-center">
                    <a class="btn btn-brand-1-medium" href="{{ route('catalog.index') }}">Перейти в каталог</a>
                </p>
            @endif
        </div>
    </div>
</section>
@endsection

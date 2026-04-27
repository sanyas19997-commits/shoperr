@extends('layouts.app')

@section('title', 'О магазине — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single block-cart">
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
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="block-content-page font-md neutral-700">
                    @if(!empty($page) && $page->content)
                        {!! $page->content !!}
                    @else
                        <p>{{ $siteSettings['site_name'] ?? 'Billaro Store' }} — интернет-магазин качественных товаров для всей семьи. Мы предлагаем большой ассортимент: одежда, обувь, игрушки, аксессуары и многое другое.</p>
                        <p>Работаем по всей России. Доставляем заказы курьером, СДЭК, Почтой России. Возможен самовывоз.</p>
                        <p>Мы гарантируем качество товаров — работаем только с проверенными поставщиками и брендами. Возврат в течение 14 дней без лишних вопросов.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('title', 'Корзина — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single block-cart">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">Корзина</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                        <li>Корзина</li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

        @if(empty($items))
            <div class="text-center py-5">
                <h4 class="font-2xl-bold neutral-700 mb-20">Ваша корзина пуста</h4>
                <a href="{{ route('catalog.index') }}" class="btn btn-buy">Перейти в каталог</a>
            </div>
        @else
            <div class="box-table-cart">
                <div class="table-responsive">
                    <table class="table table-striped table-cart">
                        <thead>
                            <tr>
                                <th class="text-start">Товар</th>
                                <th>Цена</th>
                                <th>Количество</th>
                                <th>Сумма</th>
                                <th>Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="box-product-cart">
                                            <a class="image-product-cart" href="{{ url('/product/'.$item['slug']) }}">
                                                <img src="{{ media_url($item['image'] ?? null, '/kidify/assets/imgs/page/product/img-detail2.png') }}" alt="{{ $item['name'] }}">
                                            </a>
                                            <a class="title-product-cart" href="{{ url('/product/'.$item['slug']) }}">{{ $item['name'] }}</a>
                                        </div>
                                    </td>
                                    <td><span class="brand-1">{{ number_format($item['price'], 0, ',', ' ') }} ₽</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.update', $item['id']) }}" class="cart-update-form d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <div class="product-quantity">
                                                <div class="quantity">
                                                    <input class="input-quantity border-0 text-center" type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="99" onchange="this.form.submit()">
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td><span class="brand-1">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-link-delete" style="background:none;border:0;color:#111;">
                                                <svg width="14" height="14" viewbox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.00011 4.82166L10.1251 0.696655L11.3034 1.87499L7.17844 5.99999L11.3034 10.125L10.1251 11.3033L6.00011 7.17832L1.87511 11.3033L0.696777 10.125L4.82178 5.99999L0.696777 1.87499L1.87511 0.696655L6.00011 4.82166Z" fill="#111111"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-30">
                    <div class="col-lg-7 mb-30">
                        <div class="box-button-checkout">
                            <a class="btn btn-brand-1-border-2 mr-10" href="{{ route('catalog.index') }}">Продолжить покупки
                                <svg class="icon-16 ml-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('cart.clear') }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-brand-1-border-2">Очистить корзину</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-5 mb-30">
                        <div class="box-cart-total">
                            <div class="item-total"><span class="font-sm">Сумма</span><span class="font-md-bold">{{ number_format($subtotal, 0, ',', ' ') }} ₽</span></div>
                            <div class="item-total"><span class="font-sm">Доставка</span><span class="font-md-bold">от 350 ₽</span></div>
                            <div class="item-total border-0"><span class="font-sm">Итого</span><span class="font-xl-bold">{{ number_format($subtotal, 0, ',', ' ') }} ₽</span></div>
                            <a class="btn btn-brand-1-xl-bold w-100 font-sm-bold" href="{{ route('checkout.index') }}">Перейти к оформлению</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

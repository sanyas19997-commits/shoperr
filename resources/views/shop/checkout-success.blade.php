@extends('layouts.app')

@section('title', 'Заказ оформлен — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single">
    <div class="container">
        <div class="top-head-blog text-center py-5">
            <img src="{{ asset('kidify/assets/imgs/template/icons/success.svg') }}" onerror="this.style.display='none'" alt="" style="height:80px;">
            <h2 class="font-4xl-bold mt-20">Спасибо! Заказ принят</h2>
            <p class="font-lg neutral-700 mt-15">Номер заказа: <strong class="brand-1">{{ $order->number }}</strong></p>
            <p class="font-md neutral-500 mt-10">Мы скоро свяжемся с вами по телефону <strong>{{ $order->customer_phone }}</strong> для подтверждения.</p>

            <div class="box-cart-total mx-auto mt-30" style="max-width:520px;text-align:left;">
                <div class="item-total"><span class="font-sm">Получатель</span><span class="font-md-bold">{{ $order->customer_name }}</span></div>
                <div class="item-total"><span class="font-sm">Email</span><span class="font-md-bold">{{ $order->customer_email }}</span></div>
                @if($order->city || $order->address)
                    <div class="item-total"><span class="font-sm">Адрес</span><span class="font-md-bold">{{ trim(($order->city ? $order->city.', ' : '').$order->address) }}</span></div>
                @endif
                <div class="item-total"><span class="font-sm">Способ оплаты</span><span class="font-md-bold">{{ \App\Models\Order::PAYMENT_METHODS[$order->payment_method] ?? $order->payment_method }}</span></div>
                <div class="item-total"><span class="font-sm">Способ доставки</span><span class="font-md-bold">{{ \App\Models\Order::DELIVERY_METHODS[$order->delivery_method] ?? $order->delivery_method }}</span></div>
                <div class="item-total"><span class="font-sm">Сумма товаров</span><span class="font-md-bold">{{ number_format($order->subtotal, 0, ',', ' ') }} ₽</span></div>
                <div class="item-total"><span class="font-sm">Доставка</span><span class="font-md-bold">{{ number_format($order->shipping_cost, 0, ',', ' ') }} ₽</span></div>
                <div class="item-total border-0"><span class="font-sm">Итого</span><span class="font-xl-bold">{{ number_format($order->total, 0, ',', ' ') }} ₽</span></div>
            </div>

            <div class="mt-30">
                <a class="btn btn-buy" href="{{ route('catalog.index') }}">Продолжить покупки</a>
                @auth<a class="btn btn-arrow-right ml-10" href="{{ route('account.index') }}">В личный кабинет</a>@endauth
            </div>
        </div>
    </div>
</section>
@endsection

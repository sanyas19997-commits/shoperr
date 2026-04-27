@extends('layouts.shop')

@section('title', 'Заказ оформлен')

@section('content')
    <section class="section-box mt-30">
        <div class="container">
            <div class="text-center p-30" style="background:#fff;border:1px solid #eee;border-radius:14px;max-width:680px;margin:0 auto;">
                <div style="font-size:64px;">✅</div>
                <h1 class="font-xxl-bold mb-15">Спасибо за заказ!</h1>
                <p class="font-md mb-15">Номер вашего заказа: <strong>{{ $order->number }}</strong></p>
                <p class="font-md color-gray-700 mb-20">Мы отправили подтверждение на {{ $order->customer_email }}. Менеджер свяжется с вами по телефону {{ $order->customer_phone }} для уточнения деталей.</p>
                <div class="d-flex justify-content-between font-md mb-10 pt-15 border-top">
                    <span>Сумма заказа:</span><strong>{{ number_format($order->total, 0, ',', ' ') }} ₽</strong>
                </div>
                <div class="d-flex justify-content-between font-md mb-10">
                    <span>Способ оплаты:</span><strong>{{ $order->payment_method_label }}</strong>
                </div>
                <div class="d-flex justify-content-between font-md mb-20">
                    <span>Способ доставки:</span><strong>{{ $order->delivery_method_label }}</strong>
                </div>
                <a href="{{ route('home') }}" class="btn btn-buy">На главную →</a>
            </div>
        </div>
    </section>
@endsection

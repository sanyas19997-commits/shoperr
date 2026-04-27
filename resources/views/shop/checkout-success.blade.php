@extends('layouts.shop')

@section('title', 'Заказ оформлен — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-success">
        <div class="container mt-50 mb-50">
            <div class="text-center" style="background:#fff;border:1px solid #FFCBA4;border-radius:20px;max-width:720px;margin:0 auto;padding:50px 30px;box-shadow:0 4px 20px rgba(0,0,0,0.06);">
                <div style="background:#4CAF50;width:80px;height:80px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 13L9 17L19 7" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h1 class="font-3xl-bold color-brand-3 mb-15">Спасибо за заказ!</h1>
                <p class="font-md neutral-700 mb-15">Номер вашего заказа:</p>
                <h2 class="color-brand-3 mb-20" style="font-size:32px;font-weight:700;">{{ $order->number }}</h2>
                <p class="font-md neutral-700 mb-25">Мы отправили подтверждение на <strong>{{ $order->customer_email }}</strong>.<br>Менеджер свяжется с вами по телефону <strong>{{ $order->customer_phone }}</strong> для уточнения деталей.</p>

                <div style="background:#FFF6EC;border-radius:12px;padding:20px;margin-bottom:25px;text-align:left;">
                    <div class="d-flex justify-content-between mb-10">
                        <span class="font-md neutral-700">Способ доставки:</span>
                        <strong class="font-md-bold neutral-900">{{ $order->delivery_method_label }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-10">
                        <span class="font-md neutral-700">Способ оплаты:</span>
                        <strong class="font-md-bold neutral-900">{{ $order->payment_method_label }}</strong>
                    </div>
                    <div class="border-top pt-10 mt-10" style="border-color:#FFCBA4 !important;">
                        <div class="d-flex justify-content-between">
                            <span class="font-lg-bold neutral-900">Сумма заказа:</span>
                            <strong class="color-brand-3" style="font-size:24px;font-weight:700;">{{ number_format($order->total, 0, ',', ' ') }} ₽</strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center flex-wrap" style="gap:12px;">
                    <a href="{{ route('catalog.index') }}" class="btn btn-default">← Продолжить покупки</a>
                    <a href="{{ route('home') }}" class="btn btn-brand-3">На главную</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.shop')

@section('title', 'Оформление заказа — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-checkout">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Оформление заказа</h2>
                <ul class="breadcrumb">
                    <li><a class="font-sm" href="{{ route('home') }}">Главная</a></li>
                    <li><a class="font-sm" href="{{ route('cart.index') }}">Корзина</a></li>
                    <li><a class="font-sm" href="#">Оформление</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <form action="{{ route('checkout.store') }}" method="POST" class="row">
                @csrf
                <div class="col-lg-8 col-md-12 mb-30">
                    <div class="box-checkout-form" style="background:#fff;border:1px solid #eee;border-radius:14px;padding:30px;">
                        <h4 class="font-xl-bold neutral-900 mb-20">Контактные данные</h4>
                        <div class="row">
                            <div class="col-md-6 mb-15">
                                <label class="font-sm-bold mb-5">ФИО <span style="color:red;">*</span></label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', auth()->user()?->name) }}" required>
                                @error('customer_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-md-6 mb-15">
                                <label class="font-sm-bold mb-5">Телефон <span style="color:red;">*</span></label>
                                <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone', auth()->user()?->phone) }}" placeholder="+7 (___) ___-__-__" required>
                                @error('customer_phone')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12 mb-15">
                                <label class="font-sm-bold mb-5">Email <span style="color:red;">*</span></label>
                                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', auth()->user()?->email) }}" required>
                                @error('customer_email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <h4 class="font-xl-bold neutral-900 mb-20 mt-25">Способ доставки</h4>
                        <div class="mb-15">
                            @foreach ($deliveryMethods as $key => $label)
                                <label class="d-flex align-items-center mb-10 p-15" style="border:1px solid #eee;border-radius:8px;cursor:pointer;">
                                    <input type="radio" name="delivery_method" value="{{ $key }}" {{ old('delivery_method', array_key_first($deliveryMethods)) === $key ? 'checked' : '' }} required style="margin-right:10px;">
                                    <span class="font-md neutral-900">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-15">
                                <label class="font-sm-bold mb-5">Город</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="Москва">
                            </div>
                            <div class="col-md-8 mb-15">
                                <label class="font-sm-bold mb-5">Адрес</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Улица, дом, квартира">
                            </div>
                        </div>

                        <h4 class="font-xl-bold neutral-900 mb-20 mt-25">Способ оплаты</h4>
                        <div class="mb-15">
                            @foreach ($paymentMethods as $key => $label)
                                <label class="d-flex align-items-center mb-10 p-15" style="border:1px solid #eee;border-radius:8px;cursor:pointer;">
                                    <input type="radio" name="payment_method" value="{{ $key }}" {{ old('payment_method', array_key_first($paymentMethods)) === $key ? 'checked' : '' }} required style="margin-right:10px;">
                                    <span class="font-md neutral-900">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="mb-15">
                            <label class="font-sm-bold mb-5">Комментарий к заказу</label>
                            <textarea name="comment" class="form-control" rows="3" placeholder="Например: позвонить за час до доставки">{{ old('comment') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 mb-30">
                    <div class="box-cart-summary p-25" style="background:#FFF6EC;border-radius:14px;position:sticky;top:20px;">
                        <h4 class="font-xl-bold neutral-900 mb-20">Ваш заказ</h4>
                        @foreach ($items as $row)
                            <div class="d-flex justify-content-between mb-10">
                                <span class="font-sm neutral-900">{{ $row['name'] }} × {{ $row['quantity'] }}</span>
                                <strong class="font-sm-bold neutral-900">{{ number_format($row['price'] * $row['quantity'], 0, ',', ' ') }} ₽</strong>
                            </div>
                        @endforeach
                        <div class="border-top pt-15 mt-15" style="border-color:#FFCBA4 !important;">
                            <div class="d-flex justify-content-between mb-10">
                                <span class="font-md neutral-700">Товары:</span>
                                <strong class="font-md-bold neutral-900">{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                            </div>
                        </div>
                        <div class="border-top pt-15 mt-15 mb-20" style="border-color:#FFCBA4 !important;">
                            <div class="d-flex justify-content-between">
                                <span class="font-lg-bold neutral-900">Итого:</span>
                                <strong class="color-brand-3" style="font-size:24px;font-weight:700;">{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-brand-3 w-100">Подтвердить заказ</button>
                        <p class="font-xs neutral-500 mt-15 mb-0 text-center">🔒 Нажимая «Подтвердить», вы соглашаетесь с условиями оферты</p>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

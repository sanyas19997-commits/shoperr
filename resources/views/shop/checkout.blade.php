@extends('layouts.shop')

@section('title', 'Оформление заказа')

@section('content')
    <section class="section-box mt-30">
        <div class="container">
            <h1 class="font-xxl-bold color-brand-3 mb-20">Оформление заказа</h1>

            <form action="{{ route('checkout.store') }}" method="POST" class="row">
                @csrf
                <div class="col-lg-8 mb-30">
                    <div class="p-20" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                        <h5 class="font-md-bold mb-15">Контактные данные</h5>
                        <div class="row">
                            <div class="col-md-6 mb-15">
                                <label class="form-label">ФИО *</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', auth()->user()?->name) }}" required>
                                @error('customer_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-md-6 mb-15">
                                <label class="form-label">Телефон *</label>
                                <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone', auth()->user()?->phone) }}" required>
                                @error('customer_phone')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12 mb-15">
                                <label class="form-label">Email *</label>
                                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', auth()->user()?->email) }}" required>
                                @error('customer_email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <h5 class="font-md-bold mb-15 mt-15">Доставка</h5>
                        <div class="mb-15">
                            <select name="delivery_method" class="form-control" required>
                                @foreach ($deliveryMethods as $key => $label)
                                    <option value="{{ $key }}" @selected(old('delivery_method')===$key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-15">
                                <label class="form-label">Город</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-8 mb-15">
                                <label class="form-label">Адрес</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Улица, дом, квартира">
                            </div>
                        </div>

                        <h5 class="font-md-bold mb-15 mt-15">Способ оплаты</h5>
                        <div class="mb-15">
                            <select name="payment_method" class="form-control" required>
                                @foreach ($paymentMethods as $key => $label)
                                    <option value="{{ $key }}" @selected(old('payment_method')===$key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-15">
                            <label class="form-label">Комментарий к заказу</label>
                            <textarea name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-30">
                    <div class="p-20" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                        <h5 class="font-md-bold mb-15">Ваш заказ</h5>
                        @foreach ($items as $row)
                            <div class="d-flex justify-content-between mb-10 font-sm">
                                <span>{{ $row['name'] }} × {{ $row['quantity'] }}</span>
                                <strong>{{ number_format($row['price'] * $row['quantity'], 0, ',', ' ') }} ₽</strong>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between mt-10 pt-10 border-top">
                            <span>Товары:</span><strong>{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-15 pt-10 border-top">
                            <span class="font-md-bold">К оплате:</span>
                            <strong class="color-brand-3" style="font-size:22px;">{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                        </div>
                        <button type="submit" class="btn btn-buy w-100">Подтвердить заказ</button>
                        <p class="font-xs color-gray-500 mt-10 mb-0 text-center">Нажимая «Подтвердить», вы соглашаетесь с условиями оферты.</p>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

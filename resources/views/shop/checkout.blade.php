@extends('layouts.app')

@section('title', 'Оформление заказа — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single block-checkout">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">Оформление заказа</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                        <li>Оформление</li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-7 mb-30">
                    <div class="box-form-checkout">
                        <h4 class="font-2xl-bold mb-20">Контактные данные</h4>
                        <div class="row">
                            <div class="col-md-6 mb-15">
                                <label class="font-md-bold">Имя <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-15">
                                <label class="font-md-bold">Телефон <span class="text-danger">*</span></label>
                                <input type="tel" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required>
                                @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-12 mb-15">
                                <label class="font-md-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>
                                @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <h4 class="font-2xl-bold mb-20 mt-30">Доставка</h4>
                        <div class="row">
                            <div class="col-md-12 mb-15">
                                <label class="font-md-bold">Способ доставки</label>
                                <select name="delivery_method" class="form-control" required>
                                    @foreach($deliveryMethods as $key => $label)
                                        <option value="{{ $key }}" {{ old('delivery_method')===$key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-15">
                                <label class="font-md-bold">Город</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-6 mb-15">
                                <label class="font-md-bold">Адрес</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Улица, дом, квартира">
                            </div>
                            <div class="col-md-12 mb-15">
                                <label class="font-md-bold">Комментарий к заказу</label>
                                <textarea name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
                            </div>
                        </div>

                        <h4 class="font-2xl-bold mb-20 mt-30">Способ оплаты</h4>
                        <div class="row">
                            @foreach($paymentMethods as $key => $label)
                                <div class="col-md-12 mb-10">
                                    <label class="cb-container">
                                        <input type="radio" name="payment_method" value="{{ $key }}" {{ (old('payment_method', array_key_first($paymentMethods))===$key) ? 'checked' : '' }} required>
                                        <span class="text-small ml-5">{{ $label }}</span>
                                    </label>
                                </div>
                            @endforeach
                            @error('payment_method')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 mb-30">
                    <div class="box-cart-total">
                        <h4 class="font-2xl-bold mb-20">Ваш заказ</h4>
                        @foreach($items as $item)
                            <div class="item-total">
                                <span class="font-sm">{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                <span class="font-md-bold">{{ number_format($item['price']*$item['quantity'], 0, ',', ' ') }} ₽</span>
                            </div>
                        @endforeach
                        <div class="item-total"><span class="font-sm">Сумма</span><span class="font-md-bold">{{ number_format($subtotal, 0, ',', ' ') }} ₽</span></div>
                        <div class="item-total"><span class="font-sm">Доставка</span><span class="font-md-bold">350 ₽ (или самовывоз)</span></div>
                        <div class="item-total border-0"><span class="font-sm">Итого</span><span class="font-xl-bold">{{ number_format($subtotal + 350, 0, ',', ' ') }} ₽</span></div>
                        <button type="submit" class="btn btn-brand-1-xl-bold w-100 font-sm-bold">Оформить заказ</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

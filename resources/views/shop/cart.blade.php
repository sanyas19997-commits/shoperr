@extends('layouts.shop')

@section('title', 'Корзина — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-cart">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Корзина</h2>
                <ul class="breadcrumb">
                    <li><a class="font-sm" href="{{ route('home') }}">Главная</a></li>
                    <li><a class="font-sm" href="#">Корзина</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            @if (empty($items))
                <div class="text-center py-50">
                    <div style="font-size:80px;">🛒</div>
                    <h3 class="font-xxl-bold neutral-900 mt-15 mb-15">Ваша корзина пуста</h3>
                    <p class="font-md neutral-700 mb-25">Добавьте товары из каталога, чтобы оформить заказ</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-brand-3">Перейти в каталог →</a>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 col-md-12 mb-30">
                        <div class="table-responsive" style="background:#fff;border-radius:14px;border:1px solid #eee;overflow:hidden;">
                            <table class="table table-cart align-middle mb-0">
                                <thead style="background:#FFF6EC;">
                                    <tr>
                                        <th style="padding:15px;">Товар</th>
                                        <th>Цена</th>
                                        <th>Количество</th>
                                        <th>Сумма</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $row)
                                    @php
                                        $imgIndex = (((int)($row['id'] ?? 1)) % 16) + 1;
                                        $fallbackImg = asset('kidify/assets/imgs/page/homepage1/product' . $imgIndex . '.png');
                                        $img = !empty($row['image'])
                                            ? (\Illuminate\Support\Str::startsWith($row['image'], ['http', '/']) ? $row['image'] : asset('storage/' . $row['image']))
                                            : $fallbackImg;
                                    @endphp
                                    <tr>
                                        <td style="padding:15px;">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $img }}" alt="{{ $row['name'] }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;margin-right:15px;background:#FFF6EC;padding:5px;">
                                                <div>
                                                    <a href="{{ route('product.show', $row['slug']) }}" class="font-md-bold neutral-900" style="text-decoration:none;">{{ $row['name'] }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="font-md neutral-900">{{ number_format($row['price'], 0, ',', ' ') }} ₽</span></td>
                                        <td>
                                            <form action="{{ route('cart.update', $row['id']) }}" method="POST" class="d-flex align-items-center" style="gap:5px;">
                                                @csrf @method('PATCH')
                                                <div class="d-flex align-items-center" style="border:1px solid #ddd;border-radius:6px;">
                                                    <button type="button" onclick="var i=this.nextElementSibling;i.value=Math.max(1,parseInt(i.value)-1);" style="border:0;background:transparent;width:32px;height:36px;">−</button>
                                                    <input type="number" name="quantity" value="{{ $row['quantity'] }}" min="1" max="99" style="width:50px;border:0;text-align:center;background:transparent;">
                                                    <button type="button" onclick="var i=this.previousElementSibling;i.value=Math.min(99,parseInt(i.value)+1);" style="border:0;background:transparent;width:32px;height:36px;">+</button>
                                                </div>
                                                <button type="submit" class="btn btn-brand-3-sm">OK</button>
                                            </form>
                                        </td>
                                        <td><strong class="color-brand-3 font-md-bold">{{ number_format($row['price'] * $row['quantity'], 0, ',', ' ') }} ₽</strong></td>
                                        <td>
                                            <form action="{{ route('cart.remove', $row['id']) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link" style="color:#FF4D4F;text-decoration:none;font-size:18px;" title="Удалить">✕</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-20 flex-wrap" style="gap:10px;">
                            <a href="{{ route('catalog.index') }}" class="btn btn-default">← Продолжить покупки</a>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-link" style="color:#999;">Очистить корзину</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="box-cart-summary p-25" style="background:#FFF6EC;border-radius:14px;">
                            <h4 class="font-xl-bold neutral-900 mb-20">Сумма заказа</h4>
                            <div class="d-flex justify-content-between mb-10">
                                <span class="font-md neutral-700">Товары ({{ count($items) }}):</span>
                                <strong class="font-md-bold neutral-900">{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-15">
                                <span class="font-md neutral-700">Доставка:</span>
                                <span class="font-sm neutral-500">рассчитывается на след. шаге</span>
                            </div>
                            <div class="border-top pt-15 mb-20" style="border-color:#FFCBA4 !important;">
                                <div class="d-flex justify-content-between">
                                    <span class="font-lg-bold neutral-900">Итого:</span>
                                    <strong class="color-brand-3" style="font-size:24px;font-weight:700;">{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                                </div>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-brand-3 w-100">Оформить заказ →</a>
                            <p class="font-xs neutral-500 mt-15 mb-0 text-center">🔒 Безопасное оформление</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

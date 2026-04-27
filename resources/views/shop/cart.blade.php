@extends('layouts.shop')

@section('title', 'Корзина')

@section('content')
    <section class="section-box mt-30">
        <div class="container">
            <h1 class="font-xxl-bold color-brand-3 mb-20">Корзина</h1>

            @if (empty($items))
                <div class="alert alert-info">
                    Ваша корзина пуста. <a href="{{ route('catalog.index') }}">Перейти в каталог →</a>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8">
                        <div class="table-responsive" style="background:#fff;border-radius:14px;border:1px solid #eee;">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Сумма</th><th></th></tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $row)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($row['image'])
                                                    <img src="{{ \Illuminate\Support\Str::startsWith($row['image'], ['http', '/']) ? $row['image'] : asset('storage/' . $row['image']) }}" alt="{{ $row['name'] }}" style="width:64px;height:64px;object-fit:cover;border-radius:8px;margin-right:12px;">
                                                @endif
                                                <a href="{{ route('product.show', $row['slug']) }}">{{ $row['name'] }}</a>
                                            </div>
                                        </td>
                                        <td>{{ number_format($row['price'], 0, ',', ' ') }} ₽</td>
                                        <td>
                                            <form action="{{ route('cart.update', $row['id']) }}" method="POST" class="d-flex align-items-center" style="gap:6px;">
                                                @csrf @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $row['quantity'] }}" min="1" max="99" style="width:64px;" class="form-control">
                                                <button type="submit" class="btn btn-default">OK</button>
                                            </form>
                                        </td>
                                        <td><strong>{{ number_format($row['price'] * $row['quantity'], 0, ',', ' ') }} ₽</strong></td>
                                        <td>
                                            <form action="{{ route('cart.remove', $row['id']) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-15">
                            <a href="{{ route('catalog.index') }}" class="btn btn-default">← Продолжить покупки</a>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger">Очистить корзину</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="p-20" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                            <h5 class="font-md-bold mb-15">Итого</h5>
                            <div class="d-flex justify-content-between mb-10">
                                <span>Товары:</span><strong>{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-15 border-top pt-10">
                                <span class="font-md-bold">К оплате:</span>
                                <strong class="color-brand-3" style="font-size:22px;">{{ number_format($subtotal, 0, ',', ' ') }} ₽</strong>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-buy w-100">Оформить заказ →</a>
                            <p class="font-xs color-gray-500 mt-10 mb-0">Стоимость доставки рассчитывается на следующем шаге.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

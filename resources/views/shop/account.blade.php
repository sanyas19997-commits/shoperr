@extends('layouts.app')

@section('title', 'Личный кабинет — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single block-cart">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">Личный кабинет</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li>Кабинет</li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

        <div class="row">
            <div class="col-lg-4 mb-30">
                <div class="box-cart-total">
                    <h4 class="font-2xl-bold mb-15">{{ $user['name'] }}</h4>
                    <div class="item-total"><span class="font-sm">Email</span><span class="font-md-bold">{{ $user['email'] }}</span></div>
                    @if(!empty($user['phone']))
                        <div class="item-total"><span class="font-sm">Телефон</span><span class="font-md-bold">{{ $user['phone'] }}</span></div>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="mt-20">
                        @csrf
                        <button type="submit" class="btn btn-brand-1-border-2 w-100">Выйти</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 mb-30">
                <h4 class="font-2xl-bold mb-20">Мои заказы</h4>
                @if($orders->isEmpty())
                    <p class="font-md neutral-700">У вас пока нет заказов. <a href="{{ route('catalog.index') }}" class="brand-1">Перейти в каталог</a></p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-cart">
                            <thead>
                                <tr>
                                    <th>Номер</th>
                                    <th>Дата</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td><strong>{{ $order->number }}</strong></td>
                                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        <td><span class="badge bg-light text-dark">{{ \App\Models\Order::STATUSES[$order->status] ?? $order->status }}</span></td>
                                        <td><strong>{{ number_format($order->total, 0, ',', ' ') }} ₽</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

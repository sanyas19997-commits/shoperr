@extends('layouts.shop')

@section('title', 'Личный кабинет — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-account">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Личный кабинет</h2>
                <ul class="breadcrumb"><li><a class="font-sm" href="{{ route('home') }}">Главная</a></li><li><a class="font-sm" href="#">Личный кабинет</a></li></ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <div class="row">
                <div class="col-lg-4 col-md-12 mb-30">
                    <div style="background:#FFF6EC;border-radius:14px;padding:25px;">
                        <div class="text-center mb-20">
                            <div style="width:80px;height:80px;border-radius:50%;background:#FF6E30;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:32px;font-weight:700;">
                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                            </div>
                            <h4 class="font-lg-bold neutral-900 mt-10 mb-0">{{ $user->name }}</h4>
                            <p class="font-sm neutral-700 mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="border-top pt-15" style="border-color:#FFCBA4 !important;">
                            <p class="font-sm mb-10"><strong>Email:</strong> {{ $user->email }}</p>
                            @if ($user->phone)<p class="font-sm mb-10"><strong>Телефон:</strong> {{ $user->phone }}</p>@endif
                            <p class="font-sm mb-15"><strong>Заказов:</strong> {{ $orders->count() }}</p>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-default w-100">Выйти из аккаунта</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 mb-30">
                    <h4 class="font-xl-bold neutral-900 mb-15">Мои заказы</h4>
                    @if ($orders->isEmpty())
                        <div class="text-center py-50" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                            <div style="font-size:60px;">📦</div>
                            <h5 class="neutral-900 mt-15 mb-10">У вас пока нет заказов</h5>
                            <p class="neutral-700 mb-15">Самое время выбрать что-то интересное!</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-brand-3">В каталог →</a>
                        </div>
                    @else
                        <div class="table-responsive" style="background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;">
                            <table class="table align-middle mb-0">
                                <thead style="background:#FFF6EC;">
                                    <tr>
                                        <th style="padding:15px;">№ заказа</th>
                                        <th>Дата</th>
                                        <th>Статус</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td style="padding:15px;"><strong class="font-md-bold neutral-900">{{ $order->number }}</strong></td>
                                        <td><span class="font-sm neutral-700">{{ $order->created_at->format('d.m.Y H:i') }}</span></td>
                                        <td><span class="badge" style="background:#FFC107;color:#000;padding:5px 10px;border-radius:6px;">{{ $order->status_label }}</span></td>
                                        <td><strong class="color-brand-3">{{ number_format($order->total, 0, ',', ' ') }} ₽</strong></td>
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

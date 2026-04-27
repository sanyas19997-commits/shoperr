@extends('layouts.shop')

@section('title', 'Личный кабинет')

@section('content')
    <section class="section-box mt-30">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-20">
                <h1 class="font-xxl-bold color-brand-3 mb-0">Личный кабинет</h1>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-default">Выйти</button>
                </form>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-30">
                    <div class="p-20" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                        <h5 class="font-md-bold mb-15">Профиль</h5>
                        <p class="mb-5"><strong>Имя:</strong> {{ $user->name }}</p>
                        <p class="mb-5"><strong>Email:</strong> {{ $user->email }}</p>
                        @if ($user->phone)<p class="mb-5"><strong>Телефон:</strong> {{ $user->phone }}</p>@endif
                    </div>
                </div>

                <div class="col-lg-8 mb-30">
                    <h5 class="font-md-bold mb-15">Мои заказы</h5>
                    @if ($orders->isEmpty())
                        <div class="alert alert-info">У вас пока нет заказов. <a href="{{ route('catalog.index') }}">Перейти в каталог</a></div>
                    @else
                        <div class="table-responsive" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                            <table class="table mb-0">
                                <thead><tr><th>№</th><th>Дата</th><th>Статус</th><th>Сумма</th></tr></thead>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->number }}</td>
                                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        <td><span class="badge bg-secondary">{{ $order->status_label }}</span></td>
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

@extends('layouts.app')

@section('title', 'Регистрация — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single block-cart">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">Регистрация</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li>Регистрация</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="box-form-checkout p-30">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error){{ $error }}<br>@endforeach
                        </div>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-15">
                            <label class="font-md-bold">Имя</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-15">
                            <label class="font-md-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-15">
                            <label class="font-md-bold">Телефон</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-15">
                            <label class="font-md-bold">Пароль</label>
                            <input type="password" name="password" class="form-control" minlength="6" required>
                        </div>
                        <div class="mb-15">
                            <label class="font-md-bold">Подтвердите пароль</label>
                            <input type="password" name="password_confirmation" class="form-control" minlength="6" required>
                        </div>
                        <button type="submit" class="btn btn-buy w-100">Зарегистрироваться</button>
                    </form>
                    <p class="text-center mt-20 font-md neutral-700">
                        Уже есть аккаунт? <a href="{{ route('login') }}" class="brand-1">Войти</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

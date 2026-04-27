@extends('layouts.app')

@section('title', 'Вход — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single block-cart">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">Вход в личный кабинет</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li>Вход</li>
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
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-15">
                            <label class="font-md-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-15">
                            <label class="font-md-bold">Пароль</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-15">
                            <label class="cb-container">
                                <input type="checkbox" name="remember" value="1">
                                <span class="text-small ml-5">Запомнить меня</span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-buy w-100">Войти</button>
                    </form>
                    <p class="text-center mt-20 font-md neutral-700">
                        Нет аккаунта? <a href="{{ route('register') }}" class="brand-1">Регистрация</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.shop')

@section('title', 'Вход — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-auth">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Вход</h2>
                <ul class="breadcrumb"><li><a class="font-sm" href="{{ route('home') }}">Главная</a></li><li><a class="font-sm" href="#">Вход</a></li></ul>
            </div>
        </div>
        <div class="container mt-30 mb-50">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:40px;">
                        <h3 class="font-xl-bold neutral-900 mb-20 text-center">Вход в личный кабинет</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-15">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-check mb-20">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">Запомнить меня</label>
                            </div>
                            <button type="submit" class="btn btn-brand-3 w-100 mb-15">Войти</button>
                            <p class="text-center mb-0 font-sm neutral-700">Нет аккаунта? <a href="{{ route('register') }}" style="color:#FF6E30;">Зарегистрироваться</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

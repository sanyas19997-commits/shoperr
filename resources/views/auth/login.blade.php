@extends('layouts.shop')

@section('title', 'Вход')

@section('content')
    <section class="section-box mt-30 mb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="p-30" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                        <h1 class="font-xl-bold mb-20 text-center">Вход в личный кабинет</h1>
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
                            <button type="submit" class="btn btn-buy w-100 mb-15">Войти</button>
                            <p class="text-center mb-0 font-sm">Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

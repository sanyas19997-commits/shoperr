@extends('layouts.shop')

@section('title', 'Регистрация — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-auth">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Регистрация</h2>
                <ul class="breadcrumb"><li><a class="font-sm" href="{{ route('home') }}">Главная</a></li><li><a class="font-sm" href="#">Регистрация</a></li></ul>
            </div>
        </div>
        <div class="container mt-30 mb-50">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:40px;">
                        <h3 class="font-xl-bold neutral-900 mb-20 text-center">Создать аккаунт</h3>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-15">
                                <label class="form-label">ФИО *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Телефон</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Пароль *</label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="mb-20">
                                <label class="form-label">Подтверждение пароля *</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-brand-3 w-100 mb-15">Зарегистрироваться</button>
                            <p class="text-center mb-0 font-sm neutral-700">Уже есть аккаунт? <a href="{{ route('login') }}" style="color:#FF6E30;">Войти</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.shop')

@section('title', 'Регистрация')

@section('content')
    <section class="section-box mt-30 mb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="p-30" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                        <h1 class="font-xl-bold mb-20 text-center">Регистрация</h1>
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
                            <button type="submit" class="btn btn-buy w-100 mb-15">Зарегистрироваться</button>
                            <p class="text-center mb-0 font-sm">Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

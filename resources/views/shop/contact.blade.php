@extends('layouts.shop')

@section('title', 'Контакты')

@section('content')
    <section class="section-box mt-30 mb-50">
        <div class="container">
            <h1 class="font-xxl-bold color-brand-3 mb-20">Контакты</h1>
            <div class="row">
                <div class="col-lg-5 mb-30">
                    <h5 class="font-md-bold mb-15">Свяжитесь с нами</h5>
                    <p class="font-md mb-10">📞 Телефон: <a href="tel:{{ \App\Models\Setting::get('phone') }}">{{ \App\Models\Setting::get('phone', '+7 (495) 000-00-00') }}</a></p>
                    <p class="font-md mb-10">✉ Email: <a href="mailto:{{ \App\Models\Setting::get('email') }}">{{ \App\Models\Setting::get('email', 'info@billaro.ru') }}</a></p>
                    <p class="font-md mb-10">📍 Адрес: {{ \App\Models\Setting::get('address', 'г. Москва') }}</p>
                    <p class="font-md mb-10">🕐 Режим работы: {{ \App\Models\Setting::get('working_hours', 'Пн-Пт 9:00-20:00, Сб-Вс 10:00-18:00') }}</p>
                </div>
                <div class="col-lg-7 mb-30">
                    <div class="p-20" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                        <h5 class="font-md-bold mb-15">Напишите нам</h5>
                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-15">
                                    <label class="form-label">Имя *</label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="form-label">Телефон</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="form-label">Тема</label>
                                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                                </div>
                                <div class="col-12 mb-15">
                                    <label class="form-label">Сообщение *</label>
                                    <textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
                                    @error('message')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-buy">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

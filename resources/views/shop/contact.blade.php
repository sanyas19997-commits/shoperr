@extends('layouts.shop')

@section('title', 'Контакты — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-contact">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Контакты</h2>
                <ul class="breadcrumb"><li><a class="font-sm" href="{{ route('home') }}">Главная</a></li><li><a class="font-sm" href="#">Контакты</a></li></ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <div class="row">
                <div class="col-lg-5 col-md-12 mb-30">
                    <h4 class="font-xl-bold neutral-900 mb-20">Свяжитесь с нами</h4>
                    <p class="font-md neutral-700 mb-30">Мы всегда на связи и рады ответить на любые ваши вопросы.</p>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">📞</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Телефон</h6>
                            <a href="tel:{{ preg_replace('/[^0-9+]/','',\App\Models\Setting::get('phone','+7 (495) 123-45-67')) }}" class="font-md neutral-700" style="text-decoration:none;">{{ \App\Models\Setting::get('phone', '+7 (495) 123-45-67') }}</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">✉️</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Email</h6>
                            <a href="mailto:{{ \App\Models\Setting::get('email','info@billaro.store') }}" class="font-md neutral-700" style="text-decoration:none;">{{ \App\Models\Setting::get('email', 'info@billaro.store') }}</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">📍</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Адрес</h6>
                            <p class="font-md neutral-700 mb-0">{{ \App\Models\Setting::get('address', 'г. Москва') }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">🕐</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Режим работы</h6>
                            <p class="font-md neutral-700 mb-0">{{ \App\Models\Setting::get('working_hours', \App\Models\Setting::get('work_hours', 'Пн-Пт 9:00-20:00, Сб-Вс 10:00-18:00')) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12 mb-30">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:30px;">
                        <h4 class="font-xl-bold neutral-900 mb-20">Напишите нам</h4>
                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Имя <span style="color:red;">*</span></label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Email <span style="color:red;">*</span></label>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Телефон</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Тема</label>
                                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                                </div>
                                <div class="col-12 mb-15">
                                    <label class="font-sm-bold mb-5">Сообщение <span style="color:red;">*</span></label>
                                    <textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
                                    @error('message')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-brand-3">Отправить сообщение</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

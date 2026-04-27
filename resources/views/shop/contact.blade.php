@extends('layouts.app')

@section('title', 'Контакты — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-blog-single block-cart">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">Контакты</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li>Контакты</li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

        <div class="row">
            <div class="col-lg-5 mb-30">
                <div class="box-cart-total">
                    <h4 class="font-2xl-bold mb-15">Свяжитесь с нами</h4>
                    @if(!empty($siteSettings['contact_phone']))
                        <div class="item-total"><span class="font-sm">Телефон</span><span class="font-md-bold">{{ $siteSettings['contact_phone'] }}</span></div>
                    @endif
                    @if(!empty($siteSettings['contact_email']))
                        <div class="item-total"><span class="font-sm">Email</span><span class="font-md-bold">{{ $siteSettings['contact_email'] }}</span></div>
                    @endif
                    @if(!empty($siteSettings['address']))
                        <div class="item-total"><span class="font-sm">Адрес</span><span class="font-md-bold">{{ $siteSettings['address'] }}</span></div>
                    @endif
                    @if(!empty($siteSettings['working_hours']))
                        <div class="item-total border-0"><span class="font-sm">Часы работы</span><span class="font-md-bold">{{ $siteSettings['working_hours'] }}</span></div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7 mb-30">
                <div class="box-form-checkout">
                    <h4 class="font-2xl-bold mb-20">Напишите нам</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">@foreach($errors->all() as $error){{ $error }}<br>@endforeach</div>
                    @endif
                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-15">
                                <label class="font-md-bold">Имя</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-15">
                                <label class="font-md-bold">Телефон</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-12 mb-15">
                                <label class="font-md-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-12 mb-15">
                                <label class="font-md-bold">Тема</label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                            </div>
                            <div class="col-md-12 mb-15">
                                <label class="font-md-bold">Сообщение</label>
                                <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
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

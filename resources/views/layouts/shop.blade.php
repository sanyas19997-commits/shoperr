<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Интернет-магазин Billaro Store — качественные товары для всей семьи')">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('kidify/assets/imgs/template/favicon.svg') }}">
    <link href="{{ asset('kidify/assets/css/style.css') }}?v=1.0.0" rel="stylesheet">
    <title>@yield('title', \App\Models\Setting::get('site_name', 'Billaro Store'))</title>
    @stack('head')
    @vite(['resources/css/shop.css', 'resources/js/shop.js'])
</head>
<body>
<div id="app">
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="page-loading text-center">
                    <img class="d-inline-block" src="{{ asset('kidify/assets/imgs/template/favicon.svg') }}" alt="Billaro Store">
                    <div class="page-loading-inner"><div></div><div></div><div></div></div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.header')

    @if (session('success'))
        <div class="container mt-3"><div class="alert alert-success">{{ session('success') }}</div></div>
    @endif
    @if (session('error'))
        <div class="container mt-3"><div class="alert alert-danger">{{ session('error') }}</div></div>
    @endif

    @yield('content')

    @include('layouts.partials.footer')

    {{-- Newsletter popup из шаблона Kidify --}}
    <div class="box-popup-newsletter">
        <div class="box-newsletter-overlay"></div>
        <div class="box-newsletter-wrapper">
            <div class="box-newsletter-inner">
                <a class="btn-close-popup btn-close-popup-newsletter" href="#">
                    <svg class="icon-16 d-inline-flex align-items-center justify-content-center" fill="#111111" stroke="#111111" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
                <div class="promotion-content">
                    <div class="block-info-banner">
                        <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Зима</p>
                        <h2 class="heading-banner mb-10 wow animate__animated animate__shakeX">
                            <span class="text-up">распродажа</span>
                            <span class="text-under">распродажа</span>
                        </h2>
                        <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Всё для вашего малыша</h4>
                        <div class="mt-10">
                            <a class="btn btn-double-border wow animate__animated animate__zoomIn" href="{{ route('catalog.index') }}">
                                <span>Смотреть скидки</span>
                            </a>
                        </div>
                    </div>
                    <div class="promotion-label wow animate__animated animate__heartBeat" data-wow-iteration="5">
                        <img src="{{ asset('kidify/assets/imgs/template/promotion.png') }}" alt="Billaro Store">
                    </div>
                    <div class="promotion-banner wow animate__animated animate__pulse">
                        <img src="{{ asset('kidify/assets/imgs/template/promotion-banner.png') }}" alt="Billaro Store">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor scripts -->
<script src="{{ asset('kidify/assets/js/vendors/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/waypoints.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/wow.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/magnific-popup.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/select2.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/isotope.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/scrollup.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/noUISlider.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/slider.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/counterup.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/jquery.elevatezoom.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/slick.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/jquery-ui.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/glightbox.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/main.js') }}?v=1.0.0"></script>
@stack('scripts')
</body>
</html>

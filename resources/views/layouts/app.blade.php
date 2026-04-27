<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', $siteSettings['site_description'] ?? 'Качественные товары для всей семьи')">
    <meta name="keywords" content="@yield('meta_keywords', 'детские товары, игрушки, одежда, обувь')">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('kidify/assets/imgs/template/favicon.svg') }}">
    <link href="{{ asset('kidify/assets/css/style.css?v=1.0.0') }}" rel="stylesheet">
    @vite(['resources/css/shop.css'])
    <title>@yield('title', $siteSettings['site_name'] ?? 'Billaro Store')</title>
</head>
<body>
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="page-loading text-center">
                    <img class="d-inline-block" src="{{ asset('kidify/assets/imgs/template/favicon.svg') }}" alt="{{ $siteSettings['site_name'] ?? 'Billaro Store' }}">
                    <div class="page-loading-inner">
                        <div></div><div></div><div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.header')
    @include('partials.mobile-menu')

    <main class="main">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.popups')

    <!-- jQuery / vendor scripts (1-в-1 как в исходной верстке Kidify) -->
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
    <script src="{{ asset('kidify/assets/js/vendors/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('kidify/assets/js/vendors/glightbox.min.js') }}"></script>
    <script src="{{ asset('kidify/assets/js/main.js?v=1.0.0') }}"></script>

    @vite(['resources/js/shop.js'])
    @stack('scripts')
</body>
</html>

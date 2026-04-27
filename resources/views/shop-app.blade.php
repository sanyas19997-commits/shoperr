<!DOCTYPE html>
<html lang="ru" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ \App\Models\Setting::get('site_name', 'Billaro Store') }}</title>
    <meta name="description" content="{{ \App\Models\Setting::get('site_description', 'Качественные товары для всей семьи') }}">

    <link rel="icon" href="{{ asset('kidify/assets/imgs/template/favicon.svg') }}">

    <link rel="stylesheet" href="{{ asset('kidify/assets/css/vendors/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kidify/assets/css/plugins/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kidify/assets/css/plugins/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kidify/assets/css/plugins/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('kidify/assets/css/plugins/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('kidify/assets/css/plugins/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kidify/assets/css/style.css') }}">

    @routes
    @vite(['resources/css/shop.css', 'resources/js/shop-inertia.js'])
    @inertiaHead
</head>
<body>
    @inertia

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
    <script src="{{ asset('kidify/assets/js/main.js') }}?v=2.0.0"></script>
</body>
</html>

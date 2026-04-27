<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('kidify/assets/imgs/template/favicon.svg') }}">
    <link href="{{ asset('kidify/assets/css/style.css') }}?v=1.0.0" rel="stylesheet">
    <title>@yield('title', config('app.name')) — {{ \App\Models\Setting::get('site_name', 'Billaro Store') }}</title>
    @stack('head')
    @vite(['resources/css/shop.css', 'resources/js/shop.js'])
</head>
<body>
<div id="app">
    @include('layouts.partials.header')

    <main>
        @if (session('success'))
            <div class="container mt-3"><div class="alert alert-success">{{ session('success') }}</div></div>
        @endif
        @if (session('error'))
            <div class="container mt-3"><div class="alert alert-danger">{{ session('error') }}</div></div>
        @endif
        @yield('content')
    </main>

    @include('layouts.partials.footer')
</div>

<!-- Vendor scripts -->
<script src="{{ asset('kidify/assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('kidify/assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>

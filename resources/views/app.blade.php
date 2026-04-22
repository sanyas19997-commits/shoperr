<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ShopHub') }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%230d6efd'%3E%3Cpath d='M7 4h-2l-3 9v2h2l3-11zm12 0l3 11h2v-2l-3-9h-2zm-2 5c0 2.76-2.24 5-5 5s-5-2.24-5-5'/%3E%3C/svg%3E">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app"></div>
</body>
</html>

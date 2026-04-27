{{-- Kidify mobile menu 1:1 (translated, dynamic categories) --}}
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
            <div class="mobile-menu-head">
                <div class="box-head-1">
                    <a class="logo-menu" href="{{ route('home') }}"><img alt="{{ $siteSettings['site_name'] ?? 'Billaro Store' }}" src="{{ asset('kidify/assets/imgs/template/logo.svg') }}"></a>
                    <a class="close-mobile" href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/close.svg') }}" alt="close"></a>
                </div>
                <div class="box-head-2"><a class="back-mobile" href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/back.svg') }}" alt="back"></a></div>
            </div>
            <div class="perfect-scroll">
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
                            <li class="has-children">
                                <a href="{{ route('catalog.index') }}">Каталог</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('catalog.index') }}">Все товары</a></li>
                                    @foreach(($mainCategories ?? collect()) as $cat)
                                        <li><a href="{{ route('catalog.category', $cat->slug) }}">{{ $cat->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ route('about') }}">О магазине</a></li>
                            <li class="has-children">
                                <a href="#">Сервис</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('account.index') }}">Личный кабинет</a></li>
                                    <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                                    <li><a href="{{ route('contact') }}">Контакты</a></li>
                                    @guest<li><a href="{{ route('login') }}">Войти</a></li>@endguest
                                    @guest<li><a href="{{ route('register') }}">Регистрация</a></li>@endguest
                                    @auth
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn btn-link p-0" style="text-align:left;">Выйти</button></form>
                                        </li>
                                    @endauth
                                </ul>
                            </li>
                            <li><a href="{{ route('contact') }}">Контакты</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="mobile-account">
                    <h6 class="mb-10">Аккаунт</h6>
                    <ul class="mobile-menu font-heading">
                        @auth
                            <li><a href="{{ route('account.index') }}">Личный кабинет</a></li>
                            <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn btn-link p-0">Выйти</button></form></li>
                        @else
                            <li><a href="{{ route('login') }}">Войти</a></li>
                            <li><a href="{{ route('register') }}">Регистрация</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

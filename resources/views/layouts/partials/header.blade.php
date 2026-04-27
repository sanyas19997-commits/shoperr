@php
    $cart = app(\App\Services\CartService::class);
    $rootCategories = \App\Models\Category::query()
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->with(['children' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')])
        ->take(8)
        ->get();
    $siteName = \App\Models\Setting::get('site_name', 'Billaro Store');
    $sitePhone = \App\Models\Setting::get('phone', '+7 (495) 000-00-00');
    $siteEmail = \App\Models\Setting::get('email', 'info@billaro.store');
    $siteFreeShipping = \App\Models\Setting::get('free_shipping_text', 'Бесплатная доставка при заказе от 5 000 ₽');
@endphp
<header class="header sticky-bar header-style-1">
    <div class="box-top-header">
        <div class="container">
            <div class="top-header">
                <div class="top-menu">
                    <ul class="menu-top">
                        <li><a href="{{ route('about') }}">О магазине</a></li>
                        <li><a href="{{ route('contact') }}">Контакты</a></li>
                        <li><a href="{{ route('catalog.index') }}">Открыть магазин</a></li>
                    </ul>
                </div>
                <div class="header-top-info">
                    <span class="mr-10">{{ $siteFreeShipping }}</span>
                    <a class="btn btn-brand-3-sm" href="{{ route('catalog.index') }}">Подробнее</a>
                </div>
                <div class="lang-currency">
                    <span class="mr-10">📞 <a href="tel:{{ preg_replace('/[^0-9+]/','',$sitePhone) }}" style="color:inherit;text-decoration:none;">{{ $sitePhone }}</a></span>
                    <span>RUB ₽</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="main-header">
            <div class="header-logo">
                <a class="d-flex align-items-center" href="{{ route('home') }}">
                    <img alt="{{ $siteName }}" src="{{ asset('kidify/assets/imgs/template/logo.svg') }}" onerror="this.style.display='none'">
                    <strong style="font-size:22px;color:#0E0E0E;margin-left:8px;">{{ $siteName }}</strong>
                </a>
            </div>
            <div class="header-menu">
                <div class="header-nav">
                    <nav class="nav-main-menu d-none d-xl-block">
                        <ul class="main-menu">
                            <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
                            <li class="has-mega-menu">
                                <a class="{{ request()->routeIs('catalog.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Каталог</a>
                                @if ($rootCategories->isNotEmpty())
                                    <div class="sub-menu">
                                        <div class="menu-inner">
                                            @foreach($rootCategories->take(3) as $rootCat)
                                                <div class="col-menu">
                                                    <h6 class="font-lg-bold mb-10"><a href="{{ route('catalog.category', $rootCat->slug) }}" style="color:inherit;">{{ $rootCat->name }}</a></h6>
                                                    @foreach($rootCat->children->take(8) as $child)
                                                        <a href="{{ route('catalog.category', $child->slug) }}">{{ $child->name }}</a>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                            <div class="col-menu-2">
                                                <img src="{{ asset('kidify/assets/imgs/template/megamenu.png') }}" alt="{{ $siteName }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </li>
                            <li><a href="{{ route('about') }}">О магазине</a></li>
                            <li><a href="{{ route('contact') }}">Контакты</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="header-shop">
                <div class="header-search">
                    <form class="form-search d-none d-md-flex" action="{{ route('catalog.index') }}" method="GET">
                        <div class="select-category">
                            <select class="form-control select-active" name="category" disabled>
                                <option value="">Все категории</option>
                                @foreach($rootCategories as $cat)
                                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="q" placeholder="Поиск товаров..." value="{{ request('q') }}">
                        <button type="submit"><img src="{{ asset('kidify/assets/imgs/template/icons/search.svg') }}" alt="Поиск"></button>
                    </form>
                </div>
                <div class="header-list-icons">
                    @auth
                        <a class="account-icon account" href="{{ route('account.index') }}" title="Личный кабинет">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 24C6 21.8783 6.84285 19.8434 8.34315 18.3431C9.84344 16.8429 11.8783 16 14 16C16.1217 16 18.1566 16.8429 19.6569 18.3431C21.1571 19.8434 22 21.8783 22 24H20C20 22.4087 19.3679 20.8826 18.2426 19.7574C17.1174 18.6321 15.5913 18 14 18C12.4087 18 10.8826 18.6321 9.75736 19.7574C8.63214 20.8826 8 22.4087 8 24H6ZM14 15C10.685 15 8 12.315 8 9C8 5.685 10.685 3 14 3C17.315 3 20 5.685 20 9C20 12.315 17.315 15 14 15ZM14 13C16.21 13 18 11.21 18 9C18 6.79 16.21 5 14 5C11.79 5 10 6.79 10 9C10 11.21 11.79 13 14 13Z"/>
                            </svg>
                        </a>
                    @else
                        <a class="account-icon account" href="{{ route('login') }}" title="Войти">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 24C6 21.8783 6.84285 19.8434 8.34315 18.3431C9.84344 16.8429 11.8783 16 14 16C16.1217 16 18.1566 16.8429 19.6569 18.3431C21.1571 19.8434 22 21.8783 22 24H20C20 22.4087 19.3679 20.8826 18.2426 19.7574C17.1174 18.6321 15.5913 18 14 18C12.4087 18 10.8826 18.6321 9.75736 19.7574C8.63214 20.8826 8 22.4087 8 24H6ZM14 15C10.685 15 8 12.315 8 9C8 5.685 10.685 3 14 3C17.315 3 20 5.685 20 9C20 12.315 17.315 15 14 15ZM14 13C16.21 13 18 11.21 18 9C18 6.79 16.21 5 14 5C11.79 5 10 6.79 10 9C10 11.21 11.79 13 14 13Z"/>
                            </svg>
                        </a>
                    @endauth

                    <a class="account-icon cart" href="{{ route('cart.index') }}" title="Корзина" id="cart-link">
                        <span class="number-tag" id="cart-counter" {{ $cart->count() ? '' : 'style=display:none;' }}>{{ $cart->count() }}</span>
                        <svg width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 10V8C9 6.67392 9.52678 5.40215 10.4645 4.46447C11.4021 3.52678 12.6739 3 14 3C15.3261 3 16.5979 3.52678 17.5355 4.46447C18.4732 5.40215 19 6.67392 19 8V10H22C22.2652 10 22.5196 10.1054 22.7071 10.2929C22.8946 10.4804 23 10.7348 23 11V23C23 23.2652 22.8946 23.5196 22.7071 23.7071C22.5196 23.8946 22.2652 24 22 24H6C5.73478 24 5.48043 23.8946 5.29289 23.7071C5.10536 23.5196 5 23.2652 5 23V11C5 10.7348 5.10536 10.4804 5.29289 10.2929C5.48043 10.1054 5.73478 10 6 10H9ZM9 12H7V22H21V12H19V14H17V12H11V14H9V12ZM11 10H17V8C17 7.20435 16.6839 6.44129 16.1213 5.87868C15.5587 5.31607 14.7956 5 14 5C13.2044 5 11.6839 6.44129 11.1213 5.87868C11.3161 6.44129 11 7.20435 11 8V10Z"/>
                        </svg>
                        <span class="ml-2 d-none d-md-inline" id="cart-subtotal">{{ number_format($cart->subtotal(), 0, ',', ' ') }} ₽</span>
                    </a>
                </div>

                <div class="burger-icon burger-icon-white d-block d-xl-none">
                    <span class="burger-icon-top"></span>
                    <span class="burger-icon-mid"></span>
                    <span class="burger-icon-bottom"></span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
            <div class="mobile-menu-head">
                <div class="box-head-1">
                    <a class="logo-menu" href="{{ route('home') }}">
                        <strong style="font-size:18px;">{{ $siteName }}</strong>
                    </a>
                    <a class="close-mobile" href="#"><span style="font-size:24px;">✕</span></a>
                </div>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li class="has-children">
                            <a href="{{ route('catalog.index') }}">Каталог</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('catalog.index') }}">Все товары</a></li>
                                @foreach($rootCategories as $c)
                                    <li><a href="{{ route('catalog.category', $c->slug) }}">{{ $c->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{ route('about') }}">О магазине</a></li>
                        <li><a href="{{ route('contact') }}">Контакты</a></li>
                        @auth
                            <li><a href="{{ route('account.index') }}">Личный кабинет</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Войти</a></li>
                            <li><a href="{{ route('register') }}">Регистрация</a></li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

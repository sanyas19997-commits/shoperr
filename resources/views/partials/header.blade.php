@php
    use Illuminate\Support\Str;
    $siteName = $siteSettings['site_name'] ?? 'Billaro Store';
    $sitePhone = $siteSettings['contact_phone'] ?? '';
    $headerLogo = $siteSettings['header_logo'] ?? null;
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
                    <span class="mr-10">Бесплатная доставка при заказе от 5 000 ₽</span>
                    <a class="btn btn-brand-3-sm" href="{{ route('catalog.index') }}">Подробнее</a>
                </div>
                <div class="lang-currency">
                    @if($sitePhone)
                        <span class="d-none d-md-inline-block mr-10 font-sm neutral-700"><i class="fi-rr-phone-call mr-5"></i>{{ $sitePhone }}</span>
                    @endif
                    <div class="dropdown">
                        <button class="btn btn-line-bottom dropdown-toggle" id="dropdownCurrencyHead" type="button" data-bs-toggle="dropdown" aria-expanded="false">RUB ₽</button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCurrencyHead">
                            <li><a class="dropdown-item" href="#">RUB ₽</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="main-header">
            <div class="header-logo">
                <a class="d-flex" href="{{ route('home') }}">
                    @if($headerLogo)
                        <img alt="{{ $siteName }}" src="{{ asset($headerLogo) }}">
                    @else
                        <img alt="{{ $siteName }}" src="{{ asset('kidify/assets/imgs/template/logo.svg') }}">
                    @endif
                </a>
            </div>
            <div class="header-menu">
                <div class="header-nav">
                    <nav class="nav-main-menu d-none d-xl-block">
                        <ul class="main-menu">
                            <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
                            <li class="has-mega-menu"><a class="{{ request()->routeIs('catalog.*') || request()->routeIs('product.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Каталог</a>
                                <div class="sub-menu">
                                    <div class="menu-inner">
                                        @foreach($mainCategories->take(4) as $catCol)
                                            <div class="col-menu">
                                                <h6 class="font-lg-bold mb-10">{{ $catCol->name }}</h6>
                                                <a href="{{ route('catalog.category', $catCol->slug) }}">Все товары категории</a>
                                                @foreach($catCol->children->take(8) as $sub)
                                                    <a href="{{ route('catalog.category', $sub->slug) }}">{{ $sub->name }}</a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                        <div class="col-menu col-menu-img">
                                            <a class="hover-up" href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/menu/banner.png') }}" alt="{{ $siteName }}"></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">О магазине</a></li>
                            <li><a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Контакты</a></li>
                        </ul>
                    </nav>
                    <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                </div>
            </div>
            <div class="header-account">
                <a class="account-icon search" href="#" title="Поиск">
                    <svg class="d-inline-flex align-items-center justify-content-center" width="28" height="28" viewbox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.031 18.617L24.314 22.899L22.899 24.314L18.617 20.031C17.0237 21.3082 15.042 22.0029 13 22C8.032 22 4 17.968 4 13C4 8.032 8.032 4 13 4C17.968 4 22 8.032 22 13C22.0029 15.042 21.3082 17.0237 20.031 18.617ZM18.025 17.875C19.2941 16.5699 20.0029 14.8204 20 13C20 9.132 16.867 6 13 6C9.132 6 6 9.132 6 13C6 16.867 9.132 20 13 20C14.8204 20.0029 16.5699 19.2941 17.875 18.025L18.025 17.875Z"></path>
                    </svg>
                </a>
                <a class="account-icon account" href="{{ auth()->check() ? route('account.index') : route('login') }}" title="{{ auth()->check() ? 'Личный кабинет' : 'Войти' }}">
                    <svg class="d-inline-flex align-items-center justify-content-center" width="28" height="28" viewbox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 24C6 21.8783 6.84285 19.8434 8.34315 18.3431C9.84344 16.8429 11.8783 16 14 16C16.1217 16 18.1566 16.8429 19.6569 18.3431C21.1571 19.8434 22 21.8783 22 24H20C20 22.4087 19.3679 20.8826 18.2426 19.7574C17.1174 18.6321 15.5913 18 14 18C12.4087 18 10.8826 18.6321 9.75736 19.7574C8.63214 20.8826 8 22.4087 8 24H6ZM14 15C10.685 15 8 12.315 8 9C8 5.685 10.685 3 14 3C17.315 3 20 5.685 20 9C20 12.315 17.315 15 14 15ZM14 13C16.21 13 18 11.21 18 9C18 6.79 16.21 5 14 5C11.79 5 10 6.79 10 9C10 11.21 11.79 13 14 13Z"></path>
                    </svg>
                </a>
                <a class="account-icon cart" href="{{ route('cart.index') }}" title="Корзина">
                    @if($cartCount > 0)
                        <span class="number-tag" id="cart-counter">{{ $cartCount }}</span>
                    @else
                        <span class="number-tag" id="cart-counter" style="display:none;">0</span>
                    @endif
                    <svg width="28" height="28" viewbox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 10V8C9 6.67392 9.52678 5.40215 10.4645 4.46447C11.4021 3.52678 12.6739 3 14 3C15.3261 3 16.5979 3.52678 17.5355 4.46447C18.4732 5.40215 19 6.67392 19 8V10H22C22.2652 10 22.5196 10.1054 22.7071 10.2929C22.8946 10.4804 23 10.7348 23 11V23C23 23.2652 22.8946 23.5196 22.7071 23.7071C22.5196 23.8946 22.2652 24 22 24H6C5.73478 24 5.48043 23.8946 5.29289 23.7071C5.10536 23.5196 5 23.2652 5 23V11C5 10.7348 5.10536 10.4804 5.29289 10.2929C5.48043 10.1054 5.73478 10 6 10H9ZM9 12H7V22H21V12H19V14H17V12H11V14H9V12ZM11 10H17V8C17 7.20435 16.6839 6.44129 16.1213 5.87868C15.5587 5.31607 14.7956 5 14 5C13.2044 5 12.4413 5.31607 11.8787 5.87868C11.3161 6.44129 11 7.20435 11 8V10Z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>

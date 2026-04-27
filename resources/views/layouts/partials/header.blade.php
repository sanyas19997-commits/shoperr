@php
    $cart = app(\App\Services\CartService::class);
    $allCategories = \App\Models\Category::query()->whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->take(8)->get();
    $siteName = \App\Models\Setting::get('site_name', 'Billaro Store');
    $sitePhone = \App\Models\Setting::get('phone', '+7 (495) 000-00-00');
@endphp
<header class="header sticky-bar header-style-1">
    <div class="box-top-header">
        <div class="container">
            <div class="top-header">
                <div class="top-menu">
                    <ul class="menu-top">
                        <li><a href="{{ route('about') }}">О магазине</a></li>
                        <li><a href="{{ route('contact') }}">Контакты</a></li>
                    </ul>
                </div>
                <div class="header-top-info">
                    <span class="mr-10">Бесплатная доставка при заказе от 5 000 ₽</span>
                </div>
                <div class="lang-currency">
                    <span class="text-muted">📞 {{ $sitePhone }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="main-header">
            <div class="header-logo">
                <a class="d-flex align-items-center" href="{{ route('home') }}">
                    <strong style="font-size:24px;color:#0E0E0E;">{{ $siteName }}</strong>
                </a>
            </div>

            <div class="header-menu">
                <div class="header-nav">
                    <nav class="nav-main-menu d-none d-xl-block">
                        <ul class="main-menu">
                            <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
                            <li class="has-mega-menu">
                                <a class="{{ request()->routeIs('catalog.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Каталог</a>
                                @if ($allCategories->isNotEmpty())
                                    <div class="sub-menu">
                                        <div class="menu-inner">
                                            <div class="col-menu">
                                                <h6 class="font-lg-bold mb-10">Категории</h6>
                                                @foreach ($allCategories as $c)
                                                    <a href="{{ route('catalog.category', $c->slug) }}">{{ $c->name }}</a>
                                                @endforeach
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
                <form class="form-search d-none d-md-flex" action="{{ route('catalog.index') }}" method="GET">
                    <div class="select-category">
                        <select class="form-control select-active" name="categorySlug" disabled>
                            <option value="">Все категории</option>
                        </select>
                    </div>
                    <input type="text" name="q" placeholder="Поиск товаров..." value="{{ request('q') }}">
                    <button type="submit"><img src="{{ asset('kidify/assets/imgs/template/icons/search.svg') }}" alt="Поиск" onerror="this.style.display='none'">🔍</button>
                </form>

                <div class="header-list-icons">
                    @auth
                        <a class="header-icon" href="{{ route('account.index') }}" title="Личный кабинет">👤</a>
                    @else
                        <a class="header-icon" href="{{ route('login') }}" title="Войти">👤</a>
                    @endauth

                    <a class="header-icon" href="{{ route('cart.index') }}" title="Корзина" id="cart-link">
                        <span style="position:relative;display:inline-block;">
                            🛒
                            <span id="cart-counter" class="badge bg-warning text-dark"
                                  style="position:absolute;top:-8px;right:-12px;border-radius:50%;font-size:11px;{{ $cart->count() ? '' : 'display:none;' }}">
                                {{ $cart->count() }}
                            </span>
                        </span>
                        <span class="ml-1">{{ number_format($cart->subtotal(), 0, ',', ' ') }} ₽</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar d-xl-none">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-content-area">
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav>
                        <ul class="mobile-menu">
                            <li><a href="{{ route('home') }}">Главная</a></li>
                            <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                            <li><a href="{{ route('about') }}">О магазине</a></li>
                            <li><a href="{{ route('contact') }}">Контакты</a></li>
                            @auth
                                <li><a href="{{ route('account.index') }}">Личный кабинет</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Войти</a></li>
                            @endauth
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

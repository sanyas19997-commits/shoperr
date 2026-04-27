    <div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
      <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
          <div class="mobile-menu-head">
            <div class="box-head-1"><a class="logo-menu" href="{{ route('home') }}"><img alt="Billaro Store" src="{{ asset('kidify/assets/imgs/template/logo.svg') }}"></a><a class="close-mobile" href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/close.svg') }}" alt="Billaro Store"></a></div>
            <div class="box-head-2"><a class="back-mobile" href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/back.svg') }}" alt="Billaro Store"></a></div>
          </div>
          <div class="perfect-scroll">
            <div class="mobile-menu-wrap mobile-header-border">
              <nav>
                <ul class="mobile-menu font-heading">
                  <li class="has-children"><a class="active" href="{{ route('home') }}">Главная</a>
                    <ul class="sub-menu">
                      <li><a href="{{ route('home') }}">Главные страницы - 1</a></li>
                      <li><a href="{{ route('home') }}">Главные страницы - 2</a></li>
                      <li><a href="{{ route('home') }}">Главные страницы - 3</a></li>
                      <li><a href="{{ route('home') }}">Главные страницы - 4</a></li>
                      <li><a href="{{ route('home') }}">Главные страницы - 5</a></li>
                    </ul>
                  </li>
                  <li class="has-children"><a href="{{ route('catalog.index') }}">Каталог</a>
                    <ul class="sub-menu">
                      <li><a href="{{ route('catalog.index') }}">Product List</a></li>
                      <li><a href="{{ route('catalog.index') }}">Product List 2</a></li>
                      <li><a href="{{ route('catalog.index') }}">Product List 3</a></li>
                    </ul>
                  </li>
                  <li class="has-children"><a href="fleet-list.html">Товары</a>
                    <ul class="sub-menu">
                      <li><a href="{{ route('catalog.index') }}">Product Single</a></li>
                      <li><a href="{{ route('catalog.index') }}">Карточка товара 2</a></li>
                      <li><a href="{{ route('catalog.index') }}">Карточка товара 3</a></li>
                    </ul>
                  </li>
                  <li class="has-children"><a href="{{ route('about') }}">Страницы</a>
                    <ul class="sub-menu">
                      <li><a href="{{ route('about') }}">О магазине</a></li>
                      <li><a href="{{ route('account.index') }}">Личный кабинет</a></li>
                      <li><a href="{{ route('contact') }}">Контакты</a></li>
                      <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                      <li><a href="{{ route('checkout.index') }}">Оформление</a></li>
                      <li><a href="{{ route('cart.index') }}">Сравнение товаров</a></li>
                      <li><a href="#">Ошибка 404</a></li>
                    </ul>
                  </li>
                  <li class="has-children"><a href="#">Блог</a>
                    <ul class="sub-menu">
                      <li><a href="#">Список постов</a></li>
                      <li><a href="#">Список постов 2</a></li>
                      <li><a href="#">Список постов 3</a></li>
                      <li><a href="#">Пост</a></li>
                    </ul>
                  </li>
                  <li><a href="{{ route('contact') }}">Контакты</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

{{-- Kidify footer 1:1 (translated to Russian, dynamic settings) --}}
<footer class="footer">
    <div class="footer-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                    <h5 class="neutral-900 text-uppercase mb-30">Контакты</h5>
                    <p class="neutral-900 font-lg desc-company">{{ $siteSettings['working_hours'] ?? 'Пн–Пт: 9:00 – 19:00' }}</p>
                    @if(!empty($siteSettings['phone']))
                        <p class="neutral-900 font-lg phone-footer"><a href="tel:{{ preg_replace('/[^+\d]/', '', $siteSettings['phone']) }}">{{ $siteSettings['phone'] }}</a></p>
                    @else
                        <p class="neutral-900 font-lg phone-footer"><a href="tel:+78001234567">+7 (800) 123-45-67</a></p>
                    @endif
                    @if(!empty($siteSettings['phone_2']))
                        <p class="neutral-900 font-lg phone-footer"><a href="tel:{{ preg_replace('/[^+\d]/', '', $siteSettings['phone_2']) }}">{{ $siteSettings['phone_2'] }}</a></p>
                    @endif
                    <p class="neutral-900 font-lg email-footer"><a href="mailto:{{ $siteSettings['email'] ?? 'info@billaro.store' }}">{{ $siteSettings['email'] ?? 'info@billaro.store' }}</a></p>
                </div>
                <div class="col-lg-9 mb-30">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                            <h5 class="neutral-900 text-uppercase mb-30">Магазин</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('about') }}">О магазине</a></li>
                                <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                                <li><a href="{{ route('contact') }}">Контакты</a></li>
                                <li><a href="{{ route('catalog.index', ['sort' => 'newest']) }}">Новинки</a></li>
                                <li><a href="{{ route('catalog.index', ['onsale' => 1]) }}">Распродажа</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                            <h5 class="neutral-900 text-uppercase mb-30">Покупателям</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('contact') }}">Связаться с нами</a></li>
                                <li><a href="{{ route('account.index') }}">Личный кабинет</a></li>
                                <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                                @guest<li><a href="{{ route('login') }}">Войти</a></li>@endguest
                                @guest<li><a href="{{ route('register') }}">Регистрация</a></li>@endguest
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                            <h5 class="neutral-900 text-uppercase mb-30">Помощь</h5>
                            <ul class="menu-footer">
                                <li><a href="#">Доставка</a></li>
                                <li><a href="#">Возврат</a></li>
                                <li><a href="#">Оплата</a></li>
                                <li><a href="#">Гарантии</a></li>
                                <li><a href="#">Как сделать заказ</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                            <h5 class="neutral-900 text-uppercase mb-30">Соцсети</h5>
                            <ul class="menu-footer">
                                <li><a class="facebook" href="{{ $siteSettings['social_facebook'] ?? '#' }}">Facebook</a></li>
                                <li><a class="twitter" href="{{ $siteSettings['social_twitter'] ?? '#' }}">VK</a></li>
                                <li><a class="instagram" href="{{ $siteSettings['social_instagram'] ?? '#' }}">Instagram</a></li>
                                <li><a class="pinterest" href="{{ $siteSettings['social_telegram'] ?? '#' }}">Telegram</a></li>
                                <li><a class="youtube" href="{{ $siteSettings['social_youtube'] ?? '#' }}">Youtube</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-2">
        <div class="container">
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-12 text-center text-lg-start mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <a href="{{ route('home') }}"><img src="{{ asset('kidify/assets/imgs/template/logo-footer.svg') }}" alt="{{ $siteSettings['site_name'] ?? 'Billaro Store' }}"></a>
                    </div>
                    <div class="col-lg-6 col-md-12 text-center mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <span class="body-p1 neutral-900 mr-5">©{{ date('Y') }}</span>
                        <a href="{{ route('home') }}">{{ $siteSettings['site_name'] ?? 'Billaro Store' }}</a>. Все права защищены.
                    </div>
                    <div class="col-lg-3 col-md-12 text-center text-lg-end mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center box-all-payments">
                            <div class="d-inline-block box-payments">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/mastercard.svg') }}" alt="Mastercard">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/googlepay.svg') }}" alt="Google Pay">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/payoneer.svg') }}" alt="МИР">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/applepay.svg') }}" alt="Apple Pay">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/paypal.svg') }}" alt="СБП">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

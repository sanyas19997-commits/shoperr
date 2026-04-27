@php
    $footerSiteName = \App\Models\Setting::get('site_name', 'Billaro Store');
    $footerPhone = \App\Models\Setting::get('phone', '+7 (495) 123-45-67');
    $footerEmail = \App\Models\Setting::get('email', 'info@billaro.store');
    $footerAddress = \App\Models\Setting::get('address', 'г. Москва, ул. Примерная, д. 1');
    $footerWorkHours = \App\Models\Setting::get('work_hours', 'Пн-Пт с 9:00 до 18:00');
@endphp
<footer class="footer">
    <div class="footer-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                    <h5 class="neutral-900 text-uppercase mb-30">Контакты</h5>
                    <p class="neutral-900 font-lg desc-company">{{ $footerWorkHours }}</p>
                    <p class="neutral-900 font-lg phone-footer">{{ $footerPhone }}</p>
                    <p class="neutral-900 font-lg email-footer">{{ $footerEmail }}</p>
                    <p class="neutral-900 font-lg">{{ $footerAddress }}</p>
                </div>
                <div class="col-lg-9 mb-30">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                            <h5 class="neutral-900 text-uppercase mb-30">Компания</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('about') }}">О магазине</a></li>
                                <li><a href="{{ route('contact') }}">Контакты</a></li>
                                <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                                <li><a href="{{ route('page.show', 'delivery') }}">Доставка</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                            <h5 class="neutral-900 text-uppercase mb-30">Покупателям</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                                @auth
                                    <li><a href="{{ route('account.index') }}">Личный кабинет</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">Войти</a></li>
                                    <li><a href="{{ route('register') }}">Регистрация</a></li>
                                @endauth
                                <li><a href="{{ route('page.show', 'returns') }}">Возврат товара</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                            <h5 class="neutral-900 text-uppercase mb-30">Поддержка</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('page.show', 'delivery') }}">Доставка и оплата</a></li>
                                <li><a href="{{ route('page.show', 'returns') }}">Возврат и обмен</a></li>
                                <li><a href="{{ route('page.show', 'privacy') }}">Конфиденциальность</a></li>
                                <li><a href="{{ route('contact') }}">Связаться с нами</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                            <h5 class="neutral-900 text-uppercase mb-30">Соцсети</h5>
                            <ul class="menu-footer">
                                <li><a class="facebook" href="#">Facebook</a></li>
                                <li><a class="twitter" href="#">Twitter</a></li>
                                <li><a class="instagram" href="#">Instagram</a></li>
                                <li><a class="pinterest" href="#">VKontakte</a></li>
                                <li><a class="youtube" href="#">Telegram</a></li>
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
                    <div class="col-lg-3 col-md-12 text-center text-lg-start mb-20 wow animate__animated animate__fadeIn">
                        <a href="{{ route('home') }}"><strong style="font-size:20px;">{{ $footerSiteName }}</strong></a>
                    </div>
                    <div class="col-lg-6 col-md-12 text-center mb-20 wow animate__animated animate__fadeIn">
                        <span class="body-p1 neutral-900 mr-5">© {{ date('Y') }}</span>
                        <a href="{{ route('home') }}">{{ $footerSiteName }}</a>. Все права защищены.
                    </div>
                    <div class="col-lg-3 col-md-12 text-center text-lg-end mb-20 wow animate__animated animate__fadeIn">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center box-all-payments">
                            <div class="d-inline-block box-payments">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/mastercard.svg') }}" alt="MasterCard">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/applePay.svg') }}" alt="ApplePay">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/googlepay.svg') }}" alt="GooglePay">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/payPal.svg') }}" alt="PayPal">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@php
    $siteName = $siteSettings['site_name'] ?? 'Billaro Store';
    $siteEmail = $siteSettings['contact_email'] ?? 'info@billaro.store';
    $sitePhone = $siteSettings['contact_phone'] ?? '+7 (495) 123-45-67';
    $sitePhone2 = $siteSettings['contact_phone_2'] ?? '';
    $siteHours = $siteSettings['working_hours'] ?? 'Пн–Пт 9:00 – 18:00';
    $siteAddress = $siteSettings['address'] ?? '';
@endphp
<footer class="footer">
    <div class="footer-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                    <h5 class="neutral-900 text-uppercase mb-30">Контакты</h5>
                    <p class="neutral-900 font-lg desc-company">{{ $siteHours }}</p>
                    <p class="neutral-900 font-lg phone-footer">{{ $sitePhone }}</p>
                    @if($sitePhone2)
                        <p class="neutral-900 font-lg phone-footer">{{ $sitePhone2 }}</p>
                    @endif
                    <p class="neutral-900 font-lg email-footer">{{ $siteEmail }}</p>
                    @if($siteAddress)
                        <p class="neutral-900 font-md">{{ $siteAddress }}</p>
                    @endif
                </div>
                <div class="col-lg-9 mb-30">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                            <h5 class="neutral-900 text-uppercase mb-30">Магазин</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('about') }}">О магазине</a></li>
                                <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                                <li><a href="{{ route('contact') }}">Контакты</a></li>
                                <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                            <h5 class="neutral-900 text-uppercase mb-30">Покупателю</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('contact') }}">Связаться с нами</a></li>
                                <li><a href="{{ route('contact') }}">Оплата и налоги</a></li>
                                <li><a href="{{ route('contact') }}">Бонусные баллы</a></li>
                                <li><a href="{{ route('contact') }}">Скидка студентам</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                            <h5 class="neutral-900 text-uppercase mb-30">Поддержка</h5>
                            <ul class="menu-footer">
                                <li><a href="{{ route('contact') }}">Доставка</a></li>
                                <li><a href="{{ route('contact') }}">Возврат</a></li>
                                <li><a href="{{ route('contact') }}">Возврат средств</a></li>
                                <li><a href="{{ route('contact') }}">Как оформить заказ</a></li>
                                <li><a href="{{ route('contact') }}">Отслеживание заказа</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                            <h5 class="neutral-900 text-uppercase mb-30">соцсети</h5>
                            <ul class="menu-footer">
                                <li><a class="facebook" href="#">Facebook</a></li>
                                <li><a class="twitter" href="#">VK</a></li>
                                <li><a class="instagram" href="#">Instagram</a></li>
                                <li><a class="pinterest" href="#">Pinterest</a></li>
                                <li><a class="youtube" href="#">Youtube</a></li>
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
                        <a href="{{ route('home') }}"><img src="{{ asset('kidify/assets/imgs/template/logo-footer.svg') }}" alt="{{ $siteName }}"></a>
                    </div>
                    <div class="col-lg-6 col-md-12 text-center mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <span class="body-p1 neutral-900 mr-5">©{{ date('Y') }}</span><a href="{{ route('home') }}">{{ $siteName }}</a>. Все права защищены
                    </div>
                    <div class="col-lg-3 col-md-12 text-center text-lg-end mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center box-all-payments">
                            <div class="d-inline-block box-payments">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/mastercard.svg') }}" alt="Mastercard">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/googlepay.svg') }}" alt="Google Pay">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/applepay.svg') }}" alt="Apple Pay">
                                <img src="{{ asset('kidify/assets/imgs/template/icons/paypal.svg') }}" alt="PayPal">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@php
    $siteName = \App\Models\Setting::get('site_name', 'Billaro Store');
    $sitePhone = \App\Models\Setting::get('phone', '+7 (495) 000-00-00');
    $siteEmail = \App\Models\Setting::get('email', 'info@billaro.ru');
    $siteAddress = \App\Models\Setting::get('address', 'г. Москва');
@endphp
<footer class="footer mt-50">
    <div class="container">
        <div class="footer-1 row align-items-center">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                <h4 class="font-md-bold mb-20">{{ $siteName }}</h4>
                <p class="font-sm color-gray-700">Ваш магазин товаров для всей семьи. Качественные товары, быстрая доставка по всей России.</p>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12 mb-30">
                <h6 class="font-md-bold mb-15">Покупателям</h6>
                <ul class="menu-footer">
                    <li><a href="{{ route('about') }}">О магазине</a></li>
                    <li><a href="{{ route('contact') }}">Контакты</a></li>
                    <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <h6 class="font-md-bold mb-15">Информация</h6>
                <ul class="menu-footer">
                    <li><a href="{{ route('page.show', 'delivery') }}">Доставка и оплата</a></li>
                    <li><a href="{{ route('page.show', 'returns') }}">Возврат товара</a></li>
                    <li><a href="{{ route('page.show', 'privacy') }}">Политика конфиденциальности</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <h6 class="font-md-bold mb-15">Контакты</h6>
                <p class="font-sm color-gray-700 mb-5">📞 <a href="tel:{{ preg_replace('/[^0-9+]/', '', $sitePhone) }}">{{ $sitePhone }}</a></p>
                <p class="font-sm color-gray-700 mb-5">✉ <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a></p>
                <p class="font-sm color-gray-700">📍 {{ $siteAddress }}</p>
            </div>
        </div>

        <div class="footer-2 d-flex justify-content-between align-items-center mt-30 pt-20 border-top">
            <p class="font-sm color-gray-700 mb-0">© {{ date('Y') }} {{ $siteName }}. Все права защищены.</p>
            <p class="font-sm color-gray-700 mb-0">Сделано на Laravel + Vue</p>
        </div>
    </div>
</footer>

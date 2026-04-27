    <footer class="footer">
      <div class="footer-1">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-3 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
              <h5 class="neutral-900 text-uppercase mb-30">КОНТАКТЫ</h5>
              <p class="neutral-900 font-lg desc-company">Пн–Пт: 9:00 – 19:00</p>
              <p class="neutral-900 font-lg phone-footer">+7 (800) 123-45-67</p>
              <p class="neutral-900 font-lg phone-footer">+7 (800) 765-43-21</p>
              <p class="neutral-900 font-lg email-footer">info@billaro.store</p>
            </div>
            <div class="col-lg-9 mb-30">
              <div class="row">
                <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                  <h5 class="neutral-900 text-uppercase mb-30">Магазин</h5>
                  <ul class="menu-footer">
                    @forelse($footerShopMenu ?? [] as $m)
                      <li><a href="{{ $m->url }}"@if($m->open_new_tab) target="_blank" rel="noopener"@endif>{{ $m->title }}</a></li>
                    @empty
                      <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                      <li><a href="{{ route('about') }}">О магазине</a></li>
                      <li><a href="{{ route('blog.index') }}">Блог</a></li>
                    @endforelse
                  </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                  <h5 class="neutral-900 text-uppercase mb-30">Покупателям</h5>
                  <ul class="menu-footer">
                    @forelse($footerCustomersMenu ?? [] as $m)
                      <li><a href="{{ $m->url }}"@if($m->open_new_tab) target="_blank" rel="noopener"@endif>{{ $m->title }}</a></li>
                    @empty
                      <li><a href="{{ route('account.index') }}">Мой аккаунт</a></li>
                      <li><a href="{{ route('cart.index') }}">Корзина</a></li>
                      <li><a href="{{ route('checkout.index') }}">Оформление</a></li>
                    @endforelse
                  </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                  <h5 class="neutral-900 text-uppercase mb-30">ПОМОЩЬ</h5>
                  <ul class="menu-footer">
                    @forelse($footerHelpMenu ?? [] as $m)
                      <li><a href="{{ $m->url }}"@if($m->open_new_tab) target="_blank" rel="noopener"@endif>{{ $m->title }}</a></li>
                    @empty
                      <li><a href="{{ route('about') }}">О магазине</a></li>
                      <li><a href="{{ route('contact') }}">Контакты</a></li>
                    @endforelse
                  </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                  <h5 class="neutral-900 text-uppercase mb-30">СОЦСЕТИ</h5>
                  <ul class="menu-footer">
                    <li><a class="facebook" href="#">Facebook</a></li>
                    <li><a class="twitter" href="#">Twitter</a></li>
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
              <div class="col-lg-3 col-md-12 text-center text-lg-start mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="{{ route('home') }}"><img src="{{ asset('kidify/assets/imgs/template/logo-footer.svg') }}" alt="Billaro Store"></a></div>
              <div class="col-lg-6 col-md-12 text-center mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s"><span class="body-p1 neutral-900 mr-5">©2023</span><a href="#">Billaro Store</a>. Все права защищены</div>
              <div class="col-lg-3 col-md-12 text-center text-lg-end mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                <div class="d-flex justify-content-center justify-content-lg-end align-items-center box-all-payments">
                  <div class="d-inline-block box-payments"><img src="{{ asset('kidify/assets/imgs/template/icons/mastercard.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/googlepay.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/payoneer.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/applePay.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/payPal.svg') }}" alt="Billaro Store"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

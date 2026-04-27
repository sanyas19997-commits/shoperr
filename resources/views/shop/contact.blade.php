]633;E;echo "@extends('layouts.app')";]633;C@extends('layouts.app')

@section('title', 'Контакты — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')

      <section class="section block-blog-single block-contact">
        <div class="container">
          <div class="top-head-blog">
            <div class="text-center">
              <h2 class="font-4xl-bold">Контакты</h2>
              <div class="breadcrumbs d-inline-block">
                <ul>
                  <li><a href="#">Главная</a></li>
                  <li><a href="#">Блог</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="container-1190">
          <div class="box-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1575.9094429793793!2d144.96780073900774!3d-37.817711024139996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642b6e9fcc44f%3A0x38e74745ead60eab!2sFed%20Square!5e0!3m2!1svi!2s!4v1684687900354!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div class="box-info-contact">
            <div class="row">
              <div class="col-lg-3 col-md-6 mb-15">
                <div class="cardContact cardChat">
                  <div class="cardInfo"><strong class="d-block mb-5 font-xl-bold">Chat to sales</strong>
                    <p class="font-md">Speak to our teamcom</p><a class="font-md" href="#">sales@kidify.com</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-15">
                <div class="cardContact cardChat">
                  <div class="cardInfo"><strong class="d-block mb-5 font-xl-bold">Call us</strong><a class="font-md" href="#">+01 568 253</a><a class="font-md" href="#">+01 568 253</a></div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-15">
                <div class="cardContact cardChat">
                  <div class="cardInfo"><strong class="d-block mb-5 font-xl-bold">Postal mail</strong>
                    <p class="font-md">456 Park Avenue South, Apt 7B<br>New York, NY 10016</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mb-15">
                <div class="cardContact cardChat">
                  <div class="cardInfo"><strong class="d-block mb-5 font-xl-bold">Social Network</strong>
                    <p class="font-md">456 Park Avenue South, Apt 7B<br>New York, NY 10016</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-form-contact">
            <h3 class="font-4xl-bold mb-40">Свяжитесь с нами</h3>
            @if(session('success'))<div class="alert alert-success mb-30">{{ session('success') }}</div>@endif
            <div class="row">
              <div class="col-lg-6">
                <form action="{{ route('contact.submit') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="Ваше имя *" required>
                        @error('name')<div class="text-danger font-sm mt-5">{{ $message }}</div>@enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Ваш email *" required>
                        @error('email')<div class="text-danger font-sm mt-5">{{ $message }}</div>@enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Ваш телефон">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control" type="text" name="subject" value="{{ old('subject') }}" placeholder="Тема">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <textarea class="form-control @error('message') is-invalid @enderror" rows="6" name="message" placeholder="Сообщение" required>{{ old('message') }}</textarea>
                        @error('message')<div class="text-danger font-sm mt-5">{{ $message }}</div>@enderror
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <button type="submit" class="btn btn-brand-1-medium">Отправить</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-lg-6">
                <div class="box-contact-right">
                  <h4 class="font-2xl-bold mb-10">Нужна помощь или хотите обсудить заказ?</h4>
                  <p class="font-md mb-40">По вопросам поддержки и заказов пишите на <a href="mailto:{{ $siteSettings['email'] ?? 'info@billaro.store' }}">{{ $siteSettings['email'] ?? 'info@billaro.store' }}</a> или звоните по телефону <a href="tel:{{ preg_replace('/[^+\d]/', '', $siteSettings['phone'] ?? '+78001234567') }}">{{ $siteSettings['phone'] ?? '+7 (800) 123-45-67' }}</a>.</p>
                  <h4 class="font-2xl-bold mb-10">Адрес</h4>
                  <p class="font-md"><strong class="font-md-bold">{{ $siteSettings['site_name'] ?? 'Billaro Store' }}</strong><br>{{ $siteSettings['address'] ?? 'Россия, Москва' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="section block-section block-section-gallery block-section-instagram-5">
        <div class="container">
          <div class="top-head top-head-abs justify-content-center">
            <p class="font-md-bold text-uppercase brand-1 wow fadeInDown">FOLLOW US ON INSTAGRAM</p><a class="kidify-icon" href="#">kidify.com</a>
          </div>
        </div>
        <div class="box-gallery-instagram">
          <div class="box-gallery-instagram-inner">
            <div class="gallery-item wow fadeInLeft"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInUp"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta2.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInUp"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta3.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInUp"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta4.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInRight"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta5.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInRight"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta6.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInRight d-md-block d-none"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta7.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInRight d-md-block d-none"><img src="{{ asset('kidify/assets/imgs/page/homepage4/insta8.png') }}" alt="Billaro Store"></div>
          </div>
        </div>
      </div>
    @endsection

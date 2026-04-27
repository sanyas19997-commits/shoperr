@extends('layouts.app')

@section('title', $siteSettings['site_name'] ?? 'Billaro Store - Магазин детских товаров')

@section('content')
      <section class="section banner-homepage1">
        <div class="container">
          <div class="box-swiper">
            <div class="swiper-container swiper-banner pb-0">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="box-banner-home1">
                    <div class="box-cover-image wow animate__animated animate__fadeInLeft" style="background-image:url({{ asset('kidify/assets/imgs/page/homepage1/banner.png') }})"></div>
                    <div class="box-banner-info">
                      <div class="block-sale wow animate__animated animate__fadeInTop"><img src="{{ asset('kidify/assets/imgs/page/homepage1/sale.png') }}" alt="Billaro Store"></div>
                      <div class="blockleaf rotateme"><img src="{{ asset('kidify/assets/imgs/page/homepage1/leaf.png') }}" alt="Billaro Store"></div>
                      <div class="block-info-banner">
                        <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Зима</p>
                        <h2 class="heading-banner mb-10 wow animate__animated animate__zoomIn"><span class="text-up">распродажа</span><span class="text-under">распродажа</span></h2>
                        <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Всё для вашего малыша</h4>
                        <div class="text-center mt-10"><a class="btn btn-double-border wow animate__animated animate__zoomIn" href="#"><span>Смотреть скидки</span></a><a class="btn btn-arrow-right wow animate__animated animate__zoomIn" href="#">Подробнее<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="Billaro Store"></a></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="box-banner-home1">
                    <div class="box-cover-image wow animate__animated animate__fadeInLeft" style="background-image:url({{ asset('kidify/assets/imgs/page/homepage1/banner2.png') }})"></div>
                    <div class="box-banner-info wow animate__animated animate__zoomIn">
                      <div class="block-sale wow animate__animated animate__fadeInTop"><img src="{{ asset('kidify/assets/imgs/page/homepage1/sale.png') }}" alt="Billaro Store"></div>
                      <div class="blockleaf rotateme"><img src="{{ asset('kidify/assets/imgs/page/homepage1/star.png') }}" alt="Billaro Store"></div>
                      <div class="block-info-banner">
                        <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Зима</p>
                        <h2 class="heading-banner mb-10 wow animate__animated animate__zoomIn"><span class="text-up">распродажа</span><span class="text-under">распродажа</span></h2>
                        <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Всё для вашего малыша</h4>
                        <div class="text-center mt-10"><a class="btn btn-double-border wow animate__animated animate__zoomIn" href="#"><span>Смотреть скидки</span></a><a class="btn btn-arrow-right wow animate__animated animate__zoomIn" href="#">Подробнее<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="Billaro Store"></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-pagination-button">
                <div class="swiper-pagination swiper-pagination-banner"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="section block-section block-section-categories-slider wow animate__animated animate__fadeIn">
        <div class="container">
          <div class="box-swiper">
            <div class="swiper-container swiper-9-items pb-0">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Kids Игрушки</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat2.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Плюшевый мишка</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat3.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Мальчики</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat4.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Обувь</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat5.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Кроватки</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat6.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Wood Игрушки</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat7.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Мамам</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat8.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Малыши</a></div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="cardКатегория">
                    <div class="cardImage"><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage3/cat9.png') }}" alt="Billaro Store"></a></div>
                    <div class="cardInfo"><a href="#">Милая коллекция</a></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-pagination-button">
              <div class="swiper-pagination swiper-pagination-center-bottom swiper-pagination-items-9"></div>
            </div>
          </div>
        </div>
      </div>
      <section class="section block-section-1">
        <div class="container">
          <div class="text-center">
            <p class="font-xl brand-2 wow animate__animated animate__fadeIn"><span class="rounded-text">НОВОЕ В МАГАЗИНЕ</span></p>
            <div class="box-tabs wow animate__animated animate__fadeIn">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="girls-tab" data-bs-toggle="tab" data-bs-target="#girls" type="button" role="tab" aria-controls="girls" aria-selected="true">Для девочек</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="boys-tab" data-bs-toggle="tab" data-bs-target="#boys" type="button" role="tab" aria-controls="boys" aria-selected="false">Для мальчиков</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="accessories-tab" data-bs-toggle="tab" data-bs-target="#accessories" type="button" role="tab" aria-controls="accessories" aria-selected="false">Аксессуары</button>
                </li>
              </ul>
            </div>
          </div>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="girls" role="tabpanel" aria-labelledby="girls-tab">
              <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product1.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Платье «Звёздочки»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product2.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product6.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Детская толстовка с медвежонком</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".5s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Спортивные штаны</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".7s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Джинсовая курточка</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product5.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/pa(data-wow-delay=&quot;.1s&quot;)ge/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Юбка в клетку</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product6.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Комбинезон «Божья коровка»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product2.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Подростковое трикотажное платье</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".6s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product8.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Детское платье-пачка</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="boys" role="tabpanel" aria-labelledby="boys-tab">
              <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product1.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Платье «Звёздочки»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product2.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product6.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Детская толстовка с медвежонком</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Спортивные штаны</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Джинсовая курточка</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product5.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Юбка в клетку</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product6.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Комбинезон «Божья коровка»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product2.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Подростковое трикотажное платье</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product8.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Детское платье-пачка</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="accessories" role="tabpanel" aria-labelledby="accessories-tab">
              <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product1.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Платье «Звёздочки»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product2.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product6.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Детская толстовка с медвежонком</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Спортивные штаны</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Джинсовая курточка</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product5.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Юбка в клетку</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product6.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product4.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Комбинезон «Божья коровка»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product2.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Подростковое трикотажное платье</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product8.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product3.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Детское платье-пачка</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-2">
        <div class="container">
          <div class="box-info-section2">
            <h2 class="heading-banner mb-25 wow animate__animated animate__bounceIn"><span class="text-up">Спецпредложение</span><span class="text-under">Спецпредложение</span></h2>
            <p class="font-3xl-bold neutral-900 mb-35 wow animate__animated animate__fadeIn">Специальные предложения для постоянных<br class="d-none d-lg-block">customers. Time is limited.</p><a class="btn btn-brand-3" href="#">В магазин</a>
          </div>
          <div class="block-sale-60 wow animate__animated animate__bounceIn"><img src="{{ asset('kidify/assets/imgs/page/homepage1/upto60.png') }}" alt="Billaro Store"></div>
          <div class="block-section-img wow animate__animated animate__fadeIn"><img src="{{ asset('kidify/assets/imgs/page/homepage1/bg-section2.png') }}" alt="Billaro Store"></div>
        </div>
      </section>
      <section class="section block-section-3">
        <div class="container">
          <div class="top-head">
            <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn">Категории</h4><a class="btn btn-arrow-right wow animate__animated animate__fadeIn" href="#">Смотреть все<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="Billaro Store"></a>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <div class="box-category-list mb-30">
                <ul class="menu-category">
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a class="active" href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-1.svg') }}" alt="Billaro Store">Детская мебель</a></li>
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-2.svg') }}" alt="Billaro Store">Кормление</a></li>
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-3.svg') }}" alt="Billaro Store">Спорт и активность</a></li>
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-4.svg') }}" alt="Billaro Store">Безопасность</a></li>
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-5.svg') }}" alt="Billaro Store">Уход за малышом</a></li>
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-6.svg') }}" alt="Billaro Store">Для мальчиков</a></li>
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-7.svg') }}" alt="Billaro Store">Для девочек</a></li>
                  <li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s"><a href="#"><img src="{{ asset('kidify/assets/imgs/template/icons/CategoryIcon24-8.svg') }}" alt="Billaro Store">Детское бельё</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                    <div class="cardProduct wow fadeInUp">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product9.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"></a>
                        <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Подростковое трикотажное платье</h6></a>
                        <p class="font-lg cardDesc">$16.00</p>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                    <div class="cardProduct wow fadeInUp">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product10.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"></a>
                        <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Тёплая парка</h6></a>
                        <p class="font-lg cardDesc">$16.00</p>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                    <div class="cardProduct wow fadeInUp">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product11.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product7.png') }}" alt="Billaro Store"></a>
                        <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Леггинсы для йоги</h6></a>
                        <p class="font-lg cardDesc">$16.00</p>
                      </div>
                    </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-3">
        <div class="container">
          <div class="top-head">
            <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn">Популярные товары<a class="btn btn-arrow-right neutral-500 text-capitalize ml-10 wow animate__animated animate__fadeIn" href="#">Смотреть все<img src="{{ asset('kidify/assets/imgs/template/icons/arrow-grey.svg') }}" alt="Billaro Store"></a></h4>
            <div class="box-button-swiper">
              <div class="swiper-button-prev swiper-button-prev-collection btn-prev-style-1"></div>
              <div class="swiper-button-next swiper-button-next-collection btn-next-style-1"></div>
            </div>
          </div>
          <div class="box-products wow animate__animated animate__fadeIn">
            <div class="swiper-container swiper-4-items pb-0">
              <div class="swiper-wrapper">
                <div class="swiper-slide wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product12.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product13.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Спортивные штаны</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="swiper-slide wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product13.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product15.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Комбинезон «Божья коровка»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="swiper-slide wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product14.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product13.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Комбинезон «Божья коровка»</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
                <div class="swiper-slide wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                        <div class="cardProduct wow fadeInUp">
                          <div class="cardImage">
                            <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img class="imageMain" src="{{ asset('kidify/assets/imgs/page/homepage1/product15.png') }}" alt="Billaro Store"><img class="imageHover" src="{{ asset('kidify/assets/imgs/page/homepage1/product14.png') }}" alt="Billaro Store"></a>
                            <div class="button-select"><a href="{{ route('catalog.index') }}">Add to Корзина</a></div>
                            <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                  <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                  <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg></a><a class="btn" href="#">
                                <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                                </svg></a></div>
                          </div>
                          <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                              <h6 class="font-md-bold cardTitle">Детская водолазка</h6></a>
                            <p class="font-lg cardDesc">$16.00</p>
                          </div>
                        </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-4">
        <div class="container">
          <div class="box-section-4">
            <div class="row">
              <div class="col-lg-6">
                <div class="box-collection wow animate__animated animate__fadeIn">
                  <div class="box-collection-info">
                    <h4 class="heading-4 mb-15">Для девочек</h4>
                    <p class="font-md neutral-900 mb-35">Скидка до 50% на премиальную<br class="d-none d-lg-block">детскую одежду. Спешите!</p><a class="btn btn-brand-1 text-uppercase" href="#">В магазин</a>
                  </div>
                  <div class="star-bg-2"><img src="{{ asset('kidify/assets/imgs/page/homepage1/star2.png') }}" alt="Billaro Store"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="box-collection box-collection-2 wow animate__animated animate__fadeIn">
                  <div class="box-collection-info">
                    <h4 class="heading-4 mb-15">Топ бренды</h4>
                    <p class="font-md neutral-900 mb-35">Новые бренды этого сезона.<br class="d-none d-lg-block">Скидки до 35%</p><a class="btn btn-brand-1 text-uppercase" href="#">В магазин</a>
                  </div>
                  <div class="star-bg-1"><img src="{{ asset('kidify/assets/imgs/page/homepage1/star.png') }}" alt="Billaro Store"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-5">
        <div class="container">
          <div class="top-head">
            <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn">Категории</h4><a class="btn btn-arrow-right wow animate__animated animate__fadeIn" href="#">Смотреть все<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="Billaro Store"></a>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product16.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Play-Doh Set</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product17.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Горка и качели</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product18.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Набор юного учёного</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product19.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Набор раскрасок</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".5s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product20.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Набор конструктора</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".6s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product21.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Развивающий коврик</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".7s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product22.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Набор для творчества</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".8s">
                    <div class="cardProduct cardProduct3">
                      <div class="cardImage">
                        <label class="lbl-hot">hot</label><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product23.png') }}" alt="Billaro Store"></a>
                        <div class="box-quick-button"><a class="btn" aria-label="Quick view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.25 3.75L15.75 5.25M15.75 5.25L14.25 6.75M15.75 5.25H5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M3.75 14.25L2.25 12.75M2.25 12.75L3.75 11.25M2.25 12.75L12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2.25 8.25C2.25 6.59315 3.59315 5.25 5.25 5.25" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                              <path d="M15.75 9.75C15.75 11.4069 14.4069 12.75 12.75 12.75" stroke="#294646" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg></a><a class="btn" href="#">
                            <svg class="d-inline-flex align-items-center justify-content-center" fill="none" stroke="currentЦвет" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                            </svg></a></div>
                      </div>
                      <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                          <h6 class="font-md-bold cardTitle">Детский боулинг</h6></a>
                        <div class="product-info-bottom">
                          <p class="font-lg cardDesc">$16.00</p>
                          <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                        </div>
                      </div>
                    </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-6">
        <div class="container">
          <div class="box-animal-kid">
            <div class="box-section-animal">
              <h4 class="heading-4 brand-3 mb-5 wow slideInUp wow animate__animated animate__fadeIn" data-wow-delay=".0s">Cute Animals Игрушки</h4>
              <p class="font-md mb-5 wow slideInUp wow animate__animated animate__fadeIn" data-wow-delay=".1s">Коллекция мягких игрушек<br>и деревянных игрушек ручной работы</p><a class="btn btn-brand-1" href="#">В магазин</a>
            </div>
            <div class="box-section-kid">
              <div class="d-inline-block text-center">
                <h4 class="heading-4 brand-3 mb-5 wow slideInUp wow animate__animated animate__fadeIn" data-wow-delay=".0s">Детские игры</h4>
                <p class="font-md mb-5 wow slideInUp wow animate__animated animate__fadeIn" data-wow-delay=".2s">Развитие воображения</p>
                <div class="wow animate__animated animate__fadeIn" data-wow-delay=".4s"><a class="btn btn-brand-3-sm wow slideInUp" href="#">В магазин</a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-7">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6">
              <div class="top-head">
                <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn" data-wow-delay=".0s">Хиты продаж</h4>
                <div class="box-button-swiper">
                  <div class="swiper-button-prev swiper-button-prev-group-1-bestseller btn-prev-style-1"></div>
                  <div class="swiper-button-next swiper-button-next-group-1-bestseller btn-next-style-1"></div>
                </div>
              </div>
              <div class="swiper-container swiper-1-item-bestseller pb-0 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="list-product-4">
                            <div class="cardProduct cardProduct4">
                              <div class="cardImage"><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product24.png') }}" alt="Billaro Store"></a></div>
                              <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                                  <h6 class="font-md-bold cardTitle">Детское платье-пачка</h6></a>
                                <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                                <div class="product-price-bottom">
                                  <p class="font-lg cardDesc">$185.00</p>
                                  <p class="font-lg neutral-500 cardЦенаСкидка">$196.00</p>
                                </div>
                              </div>
                            </div>
                            <div class="cardProduct cardProduct4">
                              <div class="cardImage"><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product25.png') }}" alt="Billaro Store"></a></div>
                              <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                                  <h6 class="font-md-bold cardTitle">Детская толстовка с медвежонком</h6></a>
                                <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                                <div class="product-price-bottom">
                                  <p class="font-lg cardDesc">$185.00</p>
                                  <p class="font-lg neutral-500 cardЦенаСкидка">$196.00</p>
                                </div>
                              </div>
                            </div>
                            <div class="cardProduct cardProduct4">
                              <div class="cardImage"><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product26.png') }}" alt="Billaro Store"></a></div>
                              <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                                  <h6 class="font-md-bold cardTitle">Детский сарафан</h6></a>
                                <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                                <div class="product-price-bottom">
                                  <p class="font-lg cardDesc">$185.00</p>
                                  <p class="font-lg neutral-500 cardЦенаСкидка">$196.00</p>
                                </div>
                              </div>
                            </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="top-head">
                <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn" data-wow-delay=".0s">Молниеносная распродажа</h4>
                <div class="box-button-swiper wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                  <div class="swiper-button-prev swiper-button-prev-group-1-flash btn-prev-style-1"></div>
                  <div class="swiper-button-next swiper-button-next-group-1-flash btn-next-style-1"></div>
                </div>
              </div>
              <div class="swiper-container swiper-1-item-flash pb-0 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="list-product-4">
                            <div class="cardProduct cardProduct4">
                              <div class="cardImage"><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product27.png') }}" alt="Billaro Store"></a></div>
                              <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                                  <h6 class="font-md-bold cardTitle">Праздничная рубашка</h6></a>
                                <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                                <div class="product-price-bottom">
                                  <p class="font-lg cardDesc">$185.00</p>
                                  <p class="font-lg neutral-500 cardЦенаСкидка">$196.00</p>
                                </div>
                              </div>
                            </div>
                            <div class="cardProduct cardProduct4">
                              <div class="cardImage"><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product28.png') }}" alt="Billaro Store"></a></div>
                              <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                                  <h6 class="font-md-bold cardTitle">Фланелевая рубашка</h6></a>
                                <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                                <div class="product-price-bottom">
                                  <p class="font-lg cardDesc">$185.00</p>
                                  <p class="font-lg neutral-500 cardЦенаСкидка">$196.00</p>
                                </div>
                              </div>
                            </div>
                            <div class="cardProduct cardProduct4">
                              <div class="cardImage"><a href="{{ route('catalog.index') }}"><img src="{{ asset('kidify/assets/imgs/page/homepage1/product29.png') }}" alt="Billaro Store"></a></div>
                              <div class="cardInfo"><a href="{{ route('catalog.index') }}">
                                  <h6 class="font-md-bold cardTitle">Юбка в клетку</h6></a>
                                <div class="rating"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/template/icons/star.svg') }}" alt="Billaro Store"></div>
                                <div class="product-price-bottom">
                                  <p class="font-lg cardDesc">$185.00</p>
                                  <p class="font-lg neutral-500 cardЦенаСкидка">$196.00</p>
                                </div>
                              </div>
                            </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="box-discount-items">
                <div class="box-disount-1">
                  <div class="box-info-discount wow animate__animated animate__flash" data-wow-delay=".0s">
                    <h4 class="heading-4 neutral-900 mb-10">Детское платье</h4>
                    <p class="font-md mb-20">Get an extra 30% discount</p><a class="btn btn-brand-1" href="#">В магазин</a>
                  </div>
                </div>
                <div class="box-disount-2">
                  <div class="box-info-discount wow animate__animated animate__flash" data-wow-delay=".2s">
                    <h4 class="heading-4 neutral-900 mb-10">Для девочек</h4>
                    <p class="font-md mb-20">Get an extra 50% discount</p><a class="btn btn-brand-1" href="#">В магазин</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-8">
        <div class="container">
          <div class="text-center">
            <h4 class="text-uppercase brand-1 mb-15 brush-bg wow animate__fadeIn animated">Новости and Events</h4>
            <p class="font-lg neutral-500 mb-30 wow animate__animated animate__fadeIn">Don't miss out on great promotional news or upcoming<br class="d-none d-lg-block">events in our store system</p>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeIn" data-wow-delay="0s">
                    <div class="cardBlog wow fadeInUp">
                      <div class="cardImage">
                        <div class="box-date-info">
                          <div class="box-inner-date">
                            <div class="heading-6">21</div>
                            <p class="font-md neutral-900">Июн</p>
                          </div>
                        </div><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage1/blog1.png') }}" alt="Billaro Store"></a>
                      </div>
                      <div class="cardInfo"><a class="cardTitle" href="#">
                          <h5 class="font-xl-bold">Eco-Friendly Children's Clothing: 5 Sustainable Брендs</h5></a>
                        <p class="cardDesc font-lg neutral-500">Prioritize sustainability with 5 eco-friendly brands that offer organic cotton and recycled materials for children's clothing</p><a class="btn btn-arrow-right" href="#">Читать далее<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="Billaro Store"><img class="hover-icon" src="{{ asset('kidify/assets/imgs/template/icons/arrow-hover.svg') }}" alt="Billaro Store"></a>
                      </div>
                    </div>
            </div>
            <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeIn" data-wow-delay="0.2s">
                    <div class="cardBlog wow fadeInUp">
                      <div class="cardImage">
                        <div class="box-date-info">
                          <div class="box-inner-date">
                            <div class="heading-6">21</div>
                            <p class="font-md neutral-900">Июн</p>
                          </div>
                        </div><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage1/blog2.png') }}" alt="Billaro Store"></a>
                      </div>
                      <div class="cardInfo"><a class="cardTitle" href="#">
                          <h5 class="font-xl-bold">Styling Children for Formal Events: Tips for Dressing to Impress</h5></a>
                        <p class="cardDesc font-lg neutral-500">Get tips on how to dress your child for formal events, including choosing the right attire and accessories for both style and comfort</p><a class="btn btn-arrow-right" href="#">Читать далее<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="Billaro Store"><img class="hover-icon" src="{{ asset('kidify/assets/imgs/template/icons/arrow-hover.svg') }}" alt="Billaro Store"></a>
                      </div>
                    </div>
            </div>
            <div class="col-lg-4 col-md-6 d-md-none d-lg-block wow animate__animated animate__fadeIn" data-wow-delay="0.4s">
                    <div class="cardBlog wow fadeInUp">
                      <div class="cardImage">
                        <div class="box-date-info">
                          <div class="box-inner-date">
                            <div class="heading-6">21</div>
                            <p class="font-md neutral-900">Июн</p>
                          </div>
                        </div><a href="#"><img src="{{ asset('kidify/assets/imgs/page/homepage1/blog3.png') }}" alt="Billaro Store"></a>
                      </div>
                      <div class="cardInfo"><a class="cardTitle" href="#">
                          <h5 class="font-xl-bold">Discover the Latest Trends for Kids Одежда in 2023: Top 10 Trendy Styles</h5></a>
                        <p class="cardDesc font-lg neutral-500">As the fashion industry continues to evolve, children's fashion is no exception. This article explores the latest trends for kids fashion in 2023</p><a class="btn btn-arrow-right" href="#">Читать далее<img src="{{ asset('kidify/assets/imgs/template/icons/arrow.svg') }}" alt="Billaro Store"><img class="hover-icon" src="{{ asset('kidify/assets/imgs/template/icons/arrow-hover.svg') }}" alt="Billaro Store"></a>
                      </div>
                    </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section block-section-8">
        <div class="container">
          <div class="text-center">
            <div class="top-head justify-content-center">
              <h4 class="text-uppercase brand-1 wow animate__animated animate__fadeIn" data-wow-delay=".0s">Популярные бренды</h4>
            </div>
          </div>
          <div class="text-center box-logos wow animate__animated animate__fadeIn" data-wow-delay=".0s"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-1.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-2.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-3.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-4.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-5.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-6.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-7.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-8.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-9.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-10.png') }}" alt="Billaro Store"><img src="{{ asset('kidify/assets/imgs/slider/logo/logo-11.png') }}" alt="Billaro Store"></div>
        </div>
      </section>
      <section class="section block-section-10">
        <div class="container">
          <div class="top-head justify-content-center">
            <h4 class="text-uppercase brand-1 wow fadeInDown">instagram feed</h4>
          </div>
        </div>
        <div class="box-gallery-instagram">
          <div class="box-gallery-instagram-inner">
            <div class="gallery-item wow fadeInLeft"><img src="{{ asset('kidify/assets/imgs/page/homepage1/instagram6.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInUp"><img src="{{ asset('kidify/assets/imgs/page/homepage1/instagram.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInUp"><img src="{{ asset('kidify/assets/imgs/page/homepage1/instagram2.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInUp"><img src="{{ asset('kidify/assets/imgs/page/homepage1/instagram3.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInRight"><img src="{{ asset('kidify/assets/imgs/page/homepage1/instagram4.png') }}" alt="Billaro Store"></div>
            <div class="gallery-item wow fadeInRight"><img src="{{ asset('kidify/assets/imgs/page/homepage1/instagram5.png') }}" alt="Billaro Store"></div>
          </div>
        </div>
      </section>
@endsection

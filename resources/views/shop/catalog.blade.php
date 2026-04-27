@extends('layouts.shop')

@section('title', ($category?->name ?? 'Каталог') . ' — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-shop-page">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">{{ $category->name ?? 'Каталог товаров' }}</h2>
                <ul class="breadcrumb">
                    <li><a class="font-sm" href="{{ route('home') }}">Главная</a></li>
                    <li><a class="font-sm" href="{{ route('catalog.index') }}">Каталог</a></li>
                    @if ($category)
                        <li><a class="font-sm" href="#">{{ $category->name }}</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="container mt-30">
            <div class="row">
                {{-- Sidebar --}}
                <div class="col-xl-3 col-lg-4 mb-30">
                    <div class="sidebar-shop sticky-sidebar">
                        <div class="block-filter mb-30">
                            <h5 class="font-lg-bold neutral-900 mb-15">Категории</h5>
                            <ul class="list-checkbox">
                                <li class="mb-10">
                                    <a href="{{ route('catalog.index') }}" class="font-sm {{ ! $category ? 'fw-bold' : '' }}" style="text-decoration:none;color:{{ ! $category ? '#FF6E30' : '#0E0E0E' }};">
                                        Все товары
                                    </a>
                                </li>
                                @foreach ($categories as $c)
                                    <li class="mb-10">
                                        <a href="{{ route('catalog.category', $c->slug) }}" class="font-sm {{ $category?->id === $c->id ? 'fw-bold' : '' }}" style="text-decoration:none;color:{{ $category?->id === $c->id ? '#FF6E30' : '#0E0E0E' }};">
                                            {{ $c->name }}
                                        </a>
                                        @if ($c->children->count())
                                            <ul style="padding-left:15px;margin-top:5px;">
                                                @foreach ($c->children as $sub)
                                                    <li class="mb-5">
                                                        <a href="{{ route('catalog.category', $sub->slug) }}" class="font-sm {{ $category?->id === $sub->id ? 'fw-bold' : '' }}" style="text-decoration:none;color:{{ $category?->id === $sub->id ? '#FF6E30' : '#666' }};">
                                                            — {{ $sub->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <form method="GET" class="block-filter mb-30">
                            @if ($search)<input type="hidden" name="q" value="{{ $search }}">@endif
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <h5 class="font-lg-bold neutral-900 mb-15">Цена, ₽</h5>
                            <div class="d-flex align-items-center mb-15" style="gap:8px;">
                                <input type="number" min="0" class="form-control form-control-sm" name="price_min" placeholder="от" value="{{ request('price_min') }}">
                                <span>—</span>
                                <input type="number" min="0" class="form-control form-control-sm" name="price_max" placeholder="до" value="{{ request('price_max') }}">
                            </div>
                            <button type="submit" class="btn btn-brand-3 w-100">Применить</button>
                        </form>

                        <div class="block-banner-shop wow animate__animated animate__fadeIn">
                            <img src="{{ asset('kidify/assets/imgs/page/shop/banner_12.png') }}" alt="Banner" style="max-width:100%;border-radius:12px;">
                        </div>
                    </div>
                </div>

                {{-- Products --}}
                <div class="col-xl-9 col-lg-8">
                    <form method="GET" class="box-pagination-shop d-flex justify-content-between align-items-center mb-20 flex-wrap" style="gap:10px;background:#FAFAFA;padding:15px;border-radius:8px;">
                        <div class="d-flex align-items-center" style="gap:10px;flex:1;">
                            <input type="search" class="form-control" style="max-width:280px;" name="q" value="{{ $search }}" placeholder="Поиск товаров...">
                            <button type="submit" class="btn btn-brand-3-sm">Найти</button>
                        </div>
                        <div class="d-flex align-items-center" style="gap:10px;">
                            <span class="font-sm neutral-700">Найдено: <strong>{{ $products->total() }}</strong></span>
                            <select name="sort" class="form-control select-active" onchange="this.form.submit()" style="width:auto;">
                                <option value="newest" @selected($sort==='newest')>Сначала новые</option>
                                <option value="price_asc" @selected($sort==='price_asc')>Дешевле</option>
                                <option value="price_desc" @selected($sort==='price_desc')>Дороже</option>
                                <option value="name" @selected($sort==='name')>По названию</option>
                            </select>
                        </div>
                    </form>

                    @if ($products->isEmpty())
                        <div class="text-center py-50">
                            <h4 class="neutral-700">Товары не найдены</h4>
                            <p class="font-md neutral-500 mt-10">Попробуйте изменить параметры фильтра.</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-brand-3 mt-15">Сбросить фильтры</a>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-30 wow animate__animated animate__fadeIn">
                                    @include('layouts.partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-20">
                            {{ $products->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

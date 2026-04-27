@extends('layouts.shop')

@section('title', $category?->name ?? 'Каталог')

@section('content')
    <section class="section-box shop-template mt-30">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-15">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Каталог</a></li>
                    @if ($category)<li class="breadcrumb-item active">{{ $category->name }}</li>@endif
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-20">
                <h2 class="font-xxl-bold color-brand-3 mb-0">
                    {{ $category->name ?? 'Все товары' }}
                </h2>
                <span class="font-md color-gray-700">Найдено: {{ $products->total() }}</span>
            </div>

            <div class="row">
                <div class="col-lg-3 mb-30">
                    <aside class="sidebar-left">
                        <div class="block-filter mb-30">
                            <h5 class="font-md-bold mb-15">Категории</h5>
                            <ul class="list-checkbox">
                                <li class="mb-5"><a href="{{ route('catalog.index') }}" class="{{ ! $category ? 'fw-bold' : '' }}">Все товары</a></li>
                                @foreach ($categories as $c)
                                    <li class="mb-5">
                                        <a href="{{ route('catalog.category', $c->slug) }}" class="{{ $category?->id === $c->id ? 'fw-bold' : '' }}">{{ $c->name }}</a>
                                        @if ($c->children->count())
                                            <ul style="margin-left:14px;">
                                                @foreach ($c->children as $sub)
                                                    <li><a href="{{ route('catalog.category', $sub->slug) }}" class="{{ $category?->id === $sub->id ? 'fw-bold' : '' }}">{{ $sub->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <form method="GET" class="block-filter mb-30">
                            <h5 class="font-md-bold mb-15">Фильтр по цене</h5>
                            @if ($category)<input type="hidden" name="categorySlug" value="{{ $category->slug }}">@endif
                            @if ($search)<input type="hidden" name="q" value="{{ $search }}">@endif
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <div class="d-flex gap-2 align-items-center mb-10">
                                <input type="number" min="0" class="form-control" name="price_min" placeholder="от" value="{{ request('price_min') }}">
                                <input type="number" min="0" class="form-control" name="price_max" placeholder="до" value="{{ request('price_max') }}">
                            </div>
                            <button type="submit" class="btn btn-buy w-100">Применить</button>
                        </form>
                    </aside>
                </div>

                <div class="col-lg-9">
                    <form method="GET" class="d-flex justify-content-between align-items-center mb-20 flex-wrap" style="gap:10px;">
                        @if ($category)<input type="hidden" name="categorySlug" value="{{ $category->slug }}">@endif
                        <input type="search" class="form-control" style="max-width:280px;" name="q" value="{{ $search }}" placeholder="Поиск...">
                        <div class="d-flex align-items-center" style="gap:8px;">
                            <label class="font-sm mb-0">Сортировка:</label>
                            <select name="sort" class="form-control" onchange="this.form.submit()" style="width:auto;">
                                <option value="newest" @selected($sort==='newest')>Сначала новые</option>
                                <option value="price_asc" @selected($sort==='price_asc')>Сначала дешёвые</option>
                                <option value="price_desc" @selected($sort==='price_desc')>Сначала дорогие</option>
                                <option value="name" @selected($sort==='name')>По названию</option>
                            </select>
                        </div>
                    </form>

                    @if ($products->isEmpty())
                        <div class="alert alert-info">Товары не найдены.</div>
                    @else
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
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

@extends('layouts.app')

@section('title', ($category->name ?? 'Каталог').' — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-shop-head">
    <div class="container">
        <h1 class="font-4xl-bold neutral-900">{{ $category->name ?? 'Каталог товаров' }}</h1>
        <div class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">Главная</a></li>
                <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                @if($category)
                    <li><a href="{{ route('catalog.category', $category->slug) }}">{{ $category->name }}</a></li>
                @endif
            </ul>
        </div>
        <div class="box-tags-head">
            @foreach($categories->take(8) as $cat)
                <a class="btn btn-tag" href="{{ route('catalog.category', $cat->slug) }}">{{ $cat->name }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="section content-products">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-lg-last">
                <form id="catalog-sort-form" method="GET" class="box-filter-top">
                    @foreach(request()->except(['sort','page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <div class="number-product">
                        <p class="body-p2 neutral-medium-dark">Найдено: {{ $products->total() }} товар(ов)</p>
                    </div>
                    <div class="box-sort">
                        <div class="box-sortby d-flex align-items-center">
                            <div class="dropdown dropdown-sort">
                                <button class="btn dropdown-toggle" id="dropdownSort2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @switch($sort ?? 'newest')
                                        @case('price_asc') Сначала дешевле @break
                                        @case('price_desc') Сначала дороже @break
                                        @case('name') По названию @break
                                        @default Сначала новые
                                    @endswitch
                                </button>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownSort2">
                                    <li><a class="dropdown-item {{ ($sort ?? 'newest')==='newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort'=>'newest','page'=>1]) }}">Сначала новые</a></li>
                                    <li><a class="dropdown-item {{ $sort==='price_asc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort'=>'price_asc','page'=>1]) }}">Сначала дешевле</a></li>
                                    <li><a class="dropdown-item {{ $sort==='price_desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort'=>'price_desc','page'=>1]) }}">Сначала дороже</a></li>
                                    <li><a class="dropdown-item {{ $sort==='name' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort'=>'name','page'=>1]) }}">По названию</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="box-product-lists">
                    <div class="row">
                        @forelse($products as $product)
                            <div class="col-xl-4 col-sm-6 mb-30">
                                @include('partials.product-card')
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="font-md-bold neutral-700">Товары не найдены</p>
                                <a href="{{ route('catalog.index') }}" class="btn btn-arrow-right mt-15">Сбросить фильтры</a>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if($products->hasPages())
                    <nav class="box-pagination">
                        <ul class="pagination">
                            @if($products->onFirstPage())
                                <li class="page-item disabled"><span class="page-link page-prev">←</span></li>
                            @else
                                <li class="page-item"><a class="page-link page-prev" href="{{ $products->previousPageUrl() }}">←</a></li>
                            @endif
                            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                <li class="page-item"><a class="page-link {{ $page == $products->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a></li>
                            @endforeach
                            @if($products->hasMorePages())
                                <li class="page-item"><a class="page-link page-next" href="{{ $products->nextPageUrl() }}">→</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link page-next">→</span></li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
            <div class="col-lg-3 order-lg-first">
                <div class="sidebar-left">
                    <div class="box-filters-sidebar">
                        <form method="GET" action="{{ route('catalog.index') }}">
                            <h5 class="font-3xl-bold mt-5">Фильтр</h5>
                            <div class="block-filter">
                                <h6 class="item-collapse">Категории</h6>
                                <div class="box-collapse">
                                    <ul class="list-filter-checkbox">
                                        <li>
                                            <a href="{{ route('catalog.index') }}" class="{{ ! $category ? 'active' : '' }}">
                                                <span class="text-small">Все категории</span>
                                            </a>
                                        </li>
                                        @foreach($categories as $cat)
                                            <li>
                                                <a href="{{ route('catalog.category', $cat->slug) }}" class="{{ $category && $category->id === $cat->id ? 'active' : '' }}">
                                                    <span class="text-small">{{ $cat->name }}</span>
                                                </a>
                                                @if($cat->children->count())
                                                    <ul class="list-filter-checkbox sub-filter">
                                                        @foreach($cat->children as $sub)
                                                            <li>
                                                                <a href="{{ route('catalog.category', $sub->slug) }}" class="{{ $category && $category->id === $sub->id ? 'active' : '' }}">
                                                                    <span class="text-small">— {{ $sub->name }}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="block-filter mt-30">
                                <h6 class="item-collapse">Цена</h6>
                                <div class="box-collapse">
                                    <div class="row mt-15">
                                        <div class="col-6">
                                            <input type="number" min="0" name="price_min" value="{{ $filters['price_min'] ?? '' }}" placeholder="от" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" min="0" name="price_max" value="{{ $filters['price_max'] ?? '' }}" placeholder="до" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-filter mt-30">
                                <h6 class="item-collapse">Поиск</h6>
                                <div class="box-collapse">
                                    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Название товара" class="form-control form-control-sm mt-10">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-buy mt-20 w-100">Применить</button>
                            <a href="{{ $category ? route('catalog.category', $category->slug) : route('catalog.index') }}" class="btn btn-arrow-right mt-10 d-block text-center">Сбросить</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

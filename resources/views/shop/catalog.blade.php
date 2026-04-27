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
        @if($categories->isNotEmpty())
            <div class="box-tags-head">
                @foreach($categories->take(10) as $cat)
                    <a class="btn btn-tag {{ $category && $category->id === $cat->id ? 'active' : '' }}" href="{{ route('catalog.category', $cat->slug) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="section content-products">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-lg-last">
                <div class="box-filter-top">
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
                                    <li><a class="dropdown-item {{ ($sort ?? 'newest') === 'newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest', 'page' => 1]) }}">Сначала новые</a></li>
                                    <li><a class="dropdown-item {{ $sort === 'price_asc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc', 'page' => 1]) }}">Сначала дешевле</a></li>
                                    <li><a class="dropdown-item {{ $sort === 'price_desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc', 'page' => 1]) }}">Сначала дороже</a></li>
                                    <li><a class="dropdown-item {{ $sort === 'name' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'page' => 1]) }}">По названию</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-view-style">
                            <a class="view-type view-grid active" href="#" aria-label="Grid view"></a>
                            <a class="view-type view-list" href="#" aria-label="List view"></a>
                        </div>
                    </div>
                </div>
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
                                <li class="page-item"><a class="page-link page-prev" href="{{ $products->previousPageUrl() }}" rel="prev">←</a></li>
                            @endif
                            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                <li class="page-item">
                                    <a class="page-link {{ $page == $products->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            @if($products->hasMorePages())
                                <li class="page-item"><a class="page-link page-next" href="{{ $products->nextPageUrl() }}" rel="next">→</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link page-next">→</span></li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
            <div class="col-lg-3 order-lg-first">
                <div class="sidebar-left">
                    <form method="GET" action="{{ request()->url() }}" class="box-filters-sidebar">
                        @if($search)
                            <input type="hidden" name="q" value="{{ $search }}">
                        @endif
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <h5 class="font-3xl-bold mt-5">Фильтр</h5>
                                <div class="block-filter">
                                    <h6 class="item-collapse">Категории</h6>
                                    <div class="box-collapse">
                                        <ul class="list-filter-checkbox">
                                            <li>
                                                <a href="{{ route('catalog.index') }}{{ request()->query('q') ? '?q='.urlencode(request()->query('q')) : '' }}">
                                                    <span class="text-small {{ ! $category ? 'neutral-900' : '' }}">Все товары</span>
                                                </a>
                                            </li>
                                            @foreach($categories as $cat)
                                                <li>
                                                    <a href="{{ route('catalog.category', $cat->slug) }}{{ request()->query('q') ? '?q='.urlencode(request()->query('q')) : '' }}">
                                                        <span class="text-small {{ $category && $category->id === $cat->id ? 'neutral-900' : '' }}">{{ $cat->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="block-filter">
                                    <h6 class="title-filter">Цена, ₽</h6>
                                    <div class="box-collapse">
                                        <div class="row mt-15">
                                            <div class="col-6">
                                                <input type="number" min="0" step="100" name="price_min" value="{{ $filters['price_min'] ?? '' }}" class="form-control" placeholder="от">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" min="0" step="100" name="price_max" value="{{ $filters['price_max'] ?? '' }}" class="form-control" placeholder="до">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($search)
                                <div class="col-lg-12">
                                    <div class="block-filter">
                                        <h6 class="title-filter">Запрос</h6>
                                        <p class="body-p2 neutral-medium-dark">{{ $search }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12 mt-20">
                                <button type="submit" class="btn btn-brand-1-medium w-100">Применить</button>
                                <a href="{{ route('catalog.index') }}" class="btn btn-line-bottom-3 w-100 mt-10 text-center d-block">Сбросить фильтры</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

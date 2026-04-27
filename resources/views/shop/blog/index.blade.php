@extends('layouts.app')

@section('title', 'Блог — '.($siteSettings['site_name'] ?? 'Billaro Store'))

@section('content')
<section class="section block-shop-head block-blog-head">
    <div class="container">
        <h1 class="font-5xl-bold neutral-900">Блог</h1>
        <div class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">Главная</a></li>
                <li><a href="{{ route('blog.index') }}">Блог</a></li>
                @if($category)<li><span>{{ $category }}</span></li>@endif
            </ul>
        </div>
    </div>
</section>

<section class="section content-products">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @forelse($posts as $post)
                    <div class="cardBlogStyle1 mb-40">
                        <div class="cardImage">
                            @if($post->category)<a class="tag-up" href="{{ route('blog.index', ['category' => $post->category]) }}">{{ $post->category }}</a>@endif
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ media_url($post->image, '/kidify/assets/imgs/page/blog/blog.png') }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        <div class="cardInfo">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <h2 class="font-42-bold mb-10">{{ $post->title }}</h2>
                            </a>
                            <div class="box-meta-post mb-20">
                                <span class="font-sm neutral-500">{{ optional($post->published_at)->translatedFormat('d F Y') }}</span>
                                @if($post->author)<span class="font-sm neutral-500">{{ $post->author->name }}</span>@endif
                                <span class="font-sm neutral-500">{{ $post->views }} просмотров</span>
                            </div>
                            @if($post->excerpt)
                                <p class="font-lg">{{ $post->excerpt }}</p>
                            @endif
                            <div class="mt-25 text-end">
                                <a class="btn btn-arrow-right" href="{{ route('blog.show', $post->slug) }}">
                                    Читать далее
                                    <img src="{{ asset('kidify/assets/imgs/template/icons/arrow-sm.svg') }}" alt="">
                                    <img class="hover-icon" src="{{ asset('kidify/assets/imgs/template/icons/arrow-sm.svg') }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <h4 class="font-2xl-bold neutral-700">Записей пока нет</h4>
                        <p class="font-md neutral-500 mt-15">Скоро здесь появятся статьи о детской моде, советы родителям и обзоры.</p>
                    </div>
                @endforelse

                @if($posts->hasPages())
                    <nav class="box-pagination mt-30">
                        <ul class="pagination">
                            @if($posts->onFirstPage())
                                <li class="page-item disabled"><span class="page-link page-prev">←</span></li>
                            @else
                                <li class="page-item"><a class="page-link page-prev" href="{{ $posts->previousPageUrl() }}">←</a></li>
                            @endif
                            @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                <li class="page-item">
                                    <a class="page-link {{ $page == $posts->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            @if($posts->hasMorePages())
                                <li class="page-item"><a class="page-link page-next" href="{{ $posts->nextPageUrl() }}">→</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link page-next">→</span></li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="sidebar-blog">
                    <div class="sidebar-border">
                        <h5 class="font-3xl-bold head-sidebar">Поиск</h5>
                        <div class="content-sidebar">
                            <form method="GET" action="{{ route('blog.index') }}">
                                <div class="d-flex" style="gap:8px">
                                    <input type="search" name="q" value="{{ $search }}" class="form-control" placeholder="Поиск по блогу...">
                                    <button type="submit" class="btn btn-brand-1-medium">Найти</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($categories->isNotEmpty())
                        <div class="sidebar-border mt-30">
                            <h5 class="font-3xl-bold head-sidebar">Категории</h5>
                            <div class="content-sidebar">
                                <ul class="list-filter-checkbox">
                                    <li><a href="{{ route('blog.index') }}" class="font-md {{ ! $category ? 'neutral-900' : 'neutral-700' }}">Все статьи</a></li>
                                    @foreach($categories as $cat)
                                        <li><a href="{{ route('blog.index', ['category' => $cat]) }}" class="font-md {{ $category === $cat ? 'neutral-900' : 'neutral-700' }}">{{ $cat }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if($recentPosts->isNotEmpty())
                        <div class="sidebar-border mt-30">
                            <h5 class="font-3xl-bold head-sidebar">Свежие записи</h5>
                            <div class="content-sidebar">
                                <ul class="list-featured-posts">
                                    @foreach($recentPosts as $rp)
                                        <li>
                                            <div class="cardFeaturePost">
                                                <div class="cardImage">
                                                    <a href="{{ route('blog.show', $rp->slug) }}">
                                                        <img src="{{ media_url($rp->image, '/kidify/assets/imgs/page/blog/feature.png') }}" alt="{{ $rp->title }}">
                                                    </a>
                                                </div>
                                                <div class="cardInfo">
                                                    @if($rp->category)<span class="lbl-tag-brand">{{ $rp->category }}</span>@endif
                                                    <a class="font-sm-bold link-feature" href="{{ route('blog.show', $rp->slug) }}">{{ $rp->title }}</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('title', $post->meta_title ?: ($post->title.' — '.($siteSettings['site_name'] ?? 'Billaro Store')))
@section('meta_description', $post->meta_description ?: ($post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 160)))

@section('content')
<section class="section block-shop-head block-blog-head">
    <div class="container">
        <h1 class="font-5xl-bold neutral-900">{{ $post->title }}</h1>
        <div class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">Главная</a></li>
                <li><a href="{{ route('blog.index') }}">Блог</a></li>
                @if($post->category)
                    <li><a href="{{ route('blog.index', ['category' => $post->category]) }}">{{ $post->category }}</a></li>
                @endif
                <li><span>{{ $post->title }}</span></li>
            </ul>
        </div>
    </div>
</section>

<section class="section block-blog-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cardBlogStyle1 cardBlogSingle">
                    <div class="cardImage mb-30">
                        @if($post->category)<span class="tag-up">{{ $post->category }}</span>@endif
                        <img src="{{ media_url($post->image, '/kidify/assets/imgs/page/blog/blog.png') }}" alt="{{ $post->title }}" style="width:100%;border-radius:12px;">
                    </div>
                    <div class="cardInfo">
                        <div class="box-meta-post mb-30">
                            <span class="font-sm neutral-500">{{ optional($post->published_at)->translatedFormat('d F Y') }}</span>
                            @if($post->author)<span class="font-sm neutral-500">Автор: {{ $post->author->name }}</span>@endif
                            <span class="font-sm neutral-500">{{ $post->views }} просмотров</span>
                        </div>
                        @if($post->excerpt)
                            <p class="font-xl-bold neutral-900 mb-30">{{ $post->excerpt }}</p>
                        @endif
                        <div class="post-content font-md neutral-700">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>

                @if($relatedPosts->isNotEmpty())
                    <div class="block-related-posts mt-50">
                        <h3 class="font-3xl-bold mb-30">Похожие статьи</h3>
                        <div class="row">
                            @foreach($relatedPosts as $rel)
                                <div class="col-md-4 mb-30">
                                    <div class="cardBlogStyle1">
                                        <div class="cardImage">
                                            @if($rel->category)<a class="tag-up" href="{{ route('blog.index', ['category' => $rel->category]) }}">{{ $rel->category }}</a>@endif
                                            <a href="{{ route('blog.show', $rel->slug) }}">
                                                <img src="{{ media_url($rel->image, '/kidify/assets/imgs/page/blog/blog.png') }}" alt="{{ $rel->title }}">
                                            </a>
                                        </div>
                                        <div class="cardInfo">
                                            <a href="{{ route('blog.show', $rel->slug) }}"><h6 class="font-md-bold">{{ $rel->title }}</h6></a>
                                            <span class="font-sm neutral-500">{{ optional($rel->published_at)->translatedFormat('d.m.Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="sidebar-blog">
                    <div class="sidebar-border">
                        <h5 class="font-3xl-bold head-sidebar">Поделиться</h5>
                        <div class="content-sidebar">
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="btn btn-tag mr-10 mb-10">Telegram</a>
                            <a href="https://vk.com/share.php?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn btn-tag mr-10 mb-10">VK</a>
                            <a href="https://wa.me/?text={{ urlencode($post->title.' '.url()->current()) }}" target="_blank" rel="noopener" class="btn btn-tag mr-10 mb-10">WhatsApp</a>
                        </div>
                    </div>

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

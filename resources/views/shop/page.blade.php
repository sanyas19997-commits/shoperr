@extends('layouts.app')

@section('title', $page->title.' — '.($siteSettings['site_name'] ?? 'Billaro Store'))
@section('meta_description', $page->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($page->content ?? $page->title), 160))

@section('content')
<section class="section block-blog-single block-cart">
    <div class="container">
        <div class="top-head-blog">
            <div class="text-center">
                <h2 class="font-4xl-bold">{{ $page->title }}</h2>
                <div class="breadcrumbs d-inline-block">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li>{{ $page->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="block-content-page font-md neutral-700">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

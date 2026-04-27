@extends('layouts.shop')

@section('title', $page->title . ' — ' . \App\Models\Setting::get('site_name', 'Billaro Store'))

@section('content')
    <section class="section box-section-page">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">{{ $page->title }}</h2>
                <ul class="breadcrumb">
                    <li><a class="font-sm" href="{{ route('home') }}">Главная</a></li>
                    <li><a class="font-sm" href="#">{{ $page->title }}</a></li>
                </ul>
            </div>
        </div>
        <div class="container mt-30 mb-50">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:40px;">
                        <div class="font-md neutral-900">{!! $page->body !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

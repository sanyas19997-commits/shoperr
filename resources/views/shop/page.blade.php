@extends('layouts.shop')

@section('title', $page->title)

@section('content')
    <section class="section-box mt-30 mb-50">
        <div class="container">
            <h1 class="font-xxl-bold color-brand-3 mb-20">{{ $page->title }}</h1>
            <div class="font-md color-gray-900">{!! $page->body !!}</div>
        </div>
    </section>
@endsection

@extends('website.master')
@section('content')

<div class="breadcrumbs bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="{{ route('home') }}">Trang chủ</a></span> / <span>{{ $page->name }}</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-page bg-white">
    <div class="container py-4">
        {!! $page->content !!}
    </div>
</div>


@endsection

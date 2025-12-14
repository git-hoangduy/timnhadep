@extends('website.master')
@section('content')

<div class="breadcrumbs bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="{{ route('home') }}">Trang chủ</a></span> / <span>{{ $campaign->name }}</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-campaign bg-white">
    <div class="container py-4">
        <h6 class="text-center">{{ $campaign->name }}</h6>
        <div class="mt-4">
            {!! $campaign->content !!}
        </div>
    </div>
</div>

@endsection

@extends('website.master')
@section('content')

@foreach($categories as $category)
    @if($category->productsHome()->count())
        <div class="colorlib-product pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center colorlib-heading">
                        <h2>{{ $category->name }}</h2>
                    </div>
                </div>
                <div class="row" id="product-list">
                    @foreach($category->productsHome() as $product)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4 px-1">
                            <div class="product-entry">
                                <a href="{{ route('product.detail', $product->slug) }}" class="prod-img">
                                    @if ($product->avatar()->count())
                                        <img src="{{ asset($product->avatar->image) }}" class="img-fluid" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('uploads/default.png') }}" class="img-fluid" alt="{{ $product->name }}">
                                    @endif
                                </a>
                                <div class="desc">
                                    <h2><a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h2>
                                    <span class="price">{{ number_format($product->price) }} đ</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endforeach

<div class="colorlib-partner d-none">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading colorlib-heading-sm">
                <h2>Trusted Partners</h2>
            </div>
        </div>
        <div class="row">
            <div class="col partner-col text-center">
                <img src="images/brand-1.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
            </div>
            <div class="col partner-col text-center">
                <img src="images/brand-2.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
            </div>
            <div class="col partner-col text-center">
                <img src="images/brand-3.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
            </div>
            <div class="col partner-col text-center">
                <img src="images/brand-4.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
            </div>
            <div class="col partner-col text-center">
                <img src="images/brand-5.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
            </div>
        </div>
    </div>
</div>

@endsection

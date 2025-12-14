@extends('website.master')
@section('content')

<div class="breadcrumbs bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="{{ route('home') }}">Trang chủ</a></span> / <span>Đặt hàng thành công</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product bg-white">
    <div class="container">
    <div class="row mb-5">
            <div class="col-sm-10 offset-md-1">
                <div class="process-wrap">
                    <div class="process text-center active">
                        <p><span>Bước 1</span></p>
                        <h3>Kiểm tra giỏ hàng</h3>
                    </div>
                    <div class="process text-center active">
                        <p><span>Bước 2</span></p>
                        <h3>Thông tin thanh toán</h3>
                    </div>
                    <div class="process text-center active">
                        <p><span>Bước 3</span></p>
                        <h3>Đặt hàng thành công</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 offset-sm-1 text-center">
                <p class="icon-addcart"><span><i class="icon-check"></i></span></p>
                <h5 class="mb-4">
                    Tạo đơn hàng thành công, mã đơn đơn hàng của bạn là 
                    @if (session('order'))
                        <b>{{ session('order') }}</b>
                    @endif
                </h5>
                <p>
                    <a href="{{ route('home') }}"class="btn btn-primary">Quay lại trang chủ</a>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
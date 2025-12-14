@extends('website.master')
@section('content')

<div class="breadcrumbs bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="{{ route('home') }}">Trang chủ</a></span> / <span>Thanh toán</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product bg-white">
    <div class="container">
        <div class="row row-pb-lg">
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
                    <div class="process text-center">
                        <p><span>Bước 3</span></p>
                        <h3>Đặt hàng thành công</h3>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('checkout') }}">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="mb-4 text-uppercase">Thông tin đặt hàng</h6>
                    <div class="row">
                        @if ($errors->any())
                           <div class="col-md-12">
                            <div class="alert alert-danger border-0 mb-4 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-1">{{ $error }}</p>
                                    @endforeach
                                </div>
                           </div>
                        @endif
                        <input type="hidden" name="customer_id">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" placeholder="Nhập họ tên" name="customer_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="customer_phone">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="customer_address">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cart-detail">
                                <h2>Thông tin đơn hàng</h2>
                                <ul>
                                    <li>
                                        <ul>
                                            @foreach(Cart::content() as $cart)
                                                <li><span>{{ $cart->qty }} x {{ $cart->name }}</span> <span>{{ number_format($cart->total) }} đ</span></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li><span>Tổng tiền</span> <span><b>{{ Cart::priceTotal() }} đ</b></span></li>
                                    <li><span>Khuyến mãi</span> <span><b>{{ Cart::discount() }} đ</b></span></li>
                                    <li><span>Thanh toán</span> <span class="total-payment">{{ Cart::total() }} đ</span></li>
                                </ul>
                            </div>
                    </div>

                    <div class="w-100"></div>

                    <div class="col-md-12">
                            <div class="cart-detail">
                                <h2>Phương thức thanh toán</h2>
                                <div class="form-group">
                                    <div class="custom-radio">
                                        <input type="radio" name="payment_method" id="cod" checked>
                                        <label for="cod">Thanh toán khi nhận hàng</label>
                                    </div>  
                                </div>
                                <!-- <div class="form-group">
                                    <div class="custom-radio">
                                        <input type="radio" name="payment_method" id="bank">
                                        <label for="bank">Chuyển khoản ngân hàng</label>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="agree">
                                        <label for="agree">Tôi đã đọc và chấp nhận các điều khoản và điều kiện</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p><button type="submit" class="btn btn-primary">Đặt hàng</button></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
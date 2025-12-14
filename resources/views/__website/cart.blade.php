@extends('website.master')
@section('content')

<div class="breadcrumbs bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="{{ route('home') }}">Trang chủ</a></span> / <span>Giỏ hàng</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product bg-white">
    <div class="container">
        <div class="row row-pb-lg">
            <div class="col-md-10 offset-md-1">
                <div class="process-wrap">
                    <div class="process text-center active">
                        <p><span>Bước 1</span></p>
                        <h3>Kiểm tra giỏ hàng</h3>
                    </div>
                    <div class="process text-center">
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
        @if (Cart::count())
            <div class="row pb-3 cart-products">
                <div class="col-md-12">
                    <div class="product-name d-flex">
                        <div class="one-forth text-left px-4">
                            <span>Thông tin sản phẩm</span>
                        </div>
                        <div class="one-eight text-center">
                            <span>Giá</span>
                        </div>
                        <div class="one-eight text-center cart-quantity">
                            <span>Số lượng</span>
                        </div>
                        <div class="one-eight text-center">
                            <span>Tổng cộng</span>
                        </div>
                        <div class="one-eight text-center px-4">
                            <span>Xóa</span>
                        </div>
                    </div>
                    @foreach(Cart::content() as $cart)
                        @php
                            $product = productInfo($cart->id);
                        @endphp
                        <div class="product-cart d-flex mt-2" data-id="{{ $cart->rowId }}">
                            <div class="one-forth pl-2">
                                @if ($product->avatar()->count())
                                    <div class="product-img" style="background-image: url({{ asset($product->avatar->image) }});">
                                @else
                                    <div class="product-img" style="background-image: url({{ asset('uploads/default.png') }});">
                                @endif 
                                </div>
                                <div class="display-tc">
                                    <h3>{{ $cart->name }}</h3>
                                    <div class="attributes">
                                        @if ($cart->options->count())
                                            @foreach($cart->options as $attr => $item)
                                                @php
                                                    $attrInfo = attrInfo($attr, $item);
                                                @endphp
                                                <p class="attr-item">
                                                    {{ $attrInfo['name'] }} 
                                                    @if ($attrInfo['color'] != '')
                                                        <span class="color" style="background-color: {{ $attrInfo['color'] }}" data-toggle="tooltip" data-placement="bottom" title="{{ $attrInfo['text'] }}"></span>
                                                    @else
                                                        <span class="text">{{ $attrInfo['text'] }}</span>
                                                    @endif
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="one-eight text-center">
                                <div class="display-tc">
                                    <span class="price">{{ number_format($cart->price) }} đ</span>
                                </div>
                            </div>
                            <div class="one-eight text-center cart-quantity">
                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
                                                <i class="icon-minus2"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity" class="input-number quantity" value="{{ number_format($cart->qty) }}">
                                        <span class="input-group-btn ml-1">
                                            <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                                <i class="icon-plus2"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="one-eight text-center">
                                <div class="display-tc">
                                    <span class="price"><span class="sub-total">{{ number_format($cart->total) }}</span> đ</span>
                                </div>
                            </div>
                            <div class="one-eight text-center">
                                <div class="display-tc">
                                    <a href="#" class="closed remove-cart"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row row-pb-lg cart-summary mt-4">
                <div class="col-md-12">
                    <div class="total-wrap">
                        <div class="row">
                            <div class="col-sm-8 mb-3">
                                <div class="row">
                                    <div class="col-sm-6 text-center">
                                        <input type="text" name="code" class="form-control input-number" placeholder="Nhập mã giảm giá" autocomplete="off">
                                        <small class="code-message"></small>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="submit" value="Dùng mã giảm giá" class="btn btn-primary" id="applyCoupon">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3 text-center">
                                <div class="total px-2">
                                    <div class="sub">
                                        <p><span>Tổng tiền:</span> <span class="total">{{ Cart::priceTotal() }} đ</span></p>
                                        <p class="mb-4"><span>Giảm giá:</span> <span class="discount">{{ Cart::discount() }} đ</span></p>
                                    </div>
                                    <div class="grand-total">
                                        <p><span><strong>Thanh toán:</strong></span> <span class="total-payment">{{ Cart::total() }} đ</span></p>
                                    </div>
                                    <a href="{{ route('checkout') }}" class="btn btn-primary mt-3">Tạo đơn hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row row-pb-lg cart-empty">
                <div class="col-md-12">
                    <p class="text-center">Không có sản phẩm nào trong giỏ hàng, tiếp tục <a href="">mua sắm</a></p>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
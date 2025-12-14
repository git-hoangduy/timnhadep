@if ($products->count())
    @foreach($products as $product)
    <div class="col-lg-3 col-md-4 col-sm-4 col-6 mb-2 text-center px-1">
        <div class="product-entry">
            <a href="{{ route('product.detail', $product->slug) }}" class="prod-img">
                @if ($product->avatar()->count())
                    <img src="{{ asset($product->avatar->image) }}" class="w-100 h-auto" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('uploads/default.png') }}" class="w-100 h-auto" alt="{{ $product->name }}">
                @endif
            </a>
            <div class="desc">
                <h2><a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h2>
                <span class="price">{{ number_format($product->price) }} đ</span>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-md-12 text-center mt-4">
        {!! $products->links() !!}
    </div>
@else
    <p class="ml-2">Không tìm thấy sản phẩm nào.</p>
@endif
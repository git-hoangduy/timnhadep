@extends('website.master')
@section('content')

<div class="colorlib-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading">
                <h2>{{ $category->name }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 filter-products d-none d-lg-block">
                <div class="card mb-4">
                    <div class="card-header">Lọc theo giá</div>
                    <div class="card-body">
                        <div class="price-input">
                            <div class="field">
                              <input type="text" class="form-control input-price input-min" placeholder="Từ">
                            </div>
                            <div class="separator">-</div>
                            <div class="field">
                              <input type="text" class="form-control input-price input-max" placeholder="Đến">
                            </div>
                        </div>
                        <button class="btn btn-block applyFilter">Áp dụng</button>
                    </div>
                </div>
                @if ($brands->count())
                <div class="card mb-4">
                    <div class="card-header">Thương hiệu</div>
                    <div class="card-body">
                        @foreach ($brands as $item)
                            <div class="custom-checkbox ml-1">
                                <input type="checkbox" class="filter-brand" value="{{ $item->id }}" id="brand-{{ $item->id }}">
                                <label for="brand-{{ $item->id }}">{{ $item->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-9" id="product-list">
                <div class="row">
                    @include('website.includes.product-pagination')
                </div>  
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="category_id" value="{{ $category->id }}">
@endsection
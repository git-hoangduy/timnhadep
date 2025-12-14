@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm danh mục tin mua bán
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{ route('listing-category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        @if (config('listing.category_level') > 1)
                            <div class="mb-3">
                                <label>Danh mục cha</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="">- Không có -</option>
                                    @foreach($categories as $key => $item)
                                        @include('admin.listing-category.includes.option', ['category' => $item])
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="required">Tên danh mục</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh</label>
                            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="required">Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1">Kích hoạt</option>
                                <option value="0">Không kích hoạt</option>
                            </select>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('admin.includes.notification')
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    SEO
                </div>
                <div class="card-body">
                    <form action="{{ route('setting.seo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Meta Keywords <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" title='Thẻ "Meta Keywords" cung cấp các từ khóa về nội dung của trang web được sử dụng để lập chỉ mục và xếp hạng trang web trong kết quả tìm kiếm.'></i></label>
                            <textarea class="form-control" name="meta_keywords" rows="4" placeholder="Mỗi từ khóa cách nhau bởi dấu ,">{{ setting('seo.meta_keywords') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Meta Description <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" title='Thẻ "Meta Description" là yếu tố cơ bản trong tối ưu hóa công cụ tìm kiếm (SEO) và phát triển web. Nó là một thuộc tính HTML cung cấp bản tóm tắt ngắn gọn và súc tích về nội dung trên trang web. Các công cụ tìm kiếm như Google thường hiển thị mô tả này trong kết quả tìm kiếm của họ để giúp người dùng hiểu nội dung của một trang web cụ thể.'></i></label>
                            <textarea class="form-control" name="meta_description" rows="4">{{ setting('seo.meta_description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="ogimage" class="form-label">Open graph image <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" title='Thẻ "Open graph image" giúp hiển thị ảnh đại diện của trang web khi trang web được chia sẻ trên các trang mạng xã hội.'></i></label>
                            <input class="form-control" type="file" id="ogimage" name="ogimage" accept="image/*">
                            @if (setting('seo.ogimage') != '')
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset(setting('seo.ogimage')) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

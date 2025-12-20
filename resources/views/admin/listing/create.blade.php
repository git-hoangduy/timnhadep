@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thêm tin đăng mới</h5>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    
                    <form action="{{ route('listing.store') }}" method="POST" enctype="multipart/form-data" id="listingForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                {{-- Thông tin cơ bản --}}
                                <div class="mb-3">
                                    <label class="form-label required">Tiêu đề tin đăng</label>
                                    <input type="text" class="form-control" name="name" 
                                           placeholder="Ví dụ: Cần bán căn hộ chung cư 70m² tại Sunshine City" 
                                           value="{{ old('name') }}" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Loại bất động sản</label>
                                        <select class="form-control select2" name="category_id" required>
                                            <option value="">Chọn loại bất động sản</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Hình thức</label>
                                        <select class="form-control select2" name="type" required>
                                            <option value="">Chọn hình thức</option>
                                            <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Cần bán</option>
                                            <option value="rent" {{ old('type') == 'rent' ? 'selected' : '' }}>Cho thuê</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Giá</label>
                                        <input type="text" class="form-control" name="price" 
                                               placeholder="Ví dụ: 2 tỷ, 15 triệu/tháng" 
                                               value="{{ old('price') }}" required>
                                        <small class="form-text text-muted">Nhập giá bằng chữ</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Diện tích (m²)</label>
                                        <input type="text" class="form-control" name="area" 
                                               placeholder="Ví dụ: 70, 80-100" 
                                               value="{{ old('area') }}" required>
                                        <small class="form-text text-muted">Nhập diện tích bằng số</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required">Địa chỉ</label>
                                    <input type="text" class="form-control" name="location" 
                                           placeholder="Nhập địa chỉ chi tiết" 
                                           value="{{ old('location') }}" required>
                                </div>
                                
                                {{-- Mô tả --}}
                                <div class="mb-3">
                                    <label class="form-label">Nội dung ngắn</label>
                                    <textarea name="excerpt" rows="3" class="form-control" 
                                              placeholder="Mô tả ngắn gọn về bất động sản...">{{ old('excerpt') }}</textarea>
                                </div>

                                {{-- Hình ảnh (tham khảo từ Page) --}}
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Hình ảnh (có thể chọn nhiều)</label>
                                    <input class="form-control upload-images" type="file" id="formFile" accept="image/*" multiple>
                                    <div class="preview-images mt-3" style="display: none;"></div>
                                    <input type="hidden" name="is_avatar">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Mô tả chi tiết</label>
                                    <textarea name="content" rows="6" class="form-control tinymce" 
                                              placeholder="Mô tả chi tiết về bất động sản: số phòng, hướng nhà, tiện ích, nội thất...">{{ old('content') }}</textarea>
                                </div>
                                
                                {{-- SEO --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Keywords</label>
                                        <textarea name="meta_keywords" rows="2" class="form-control" 
                                                  placeholder="Mỗi từ khóa cách nhau bởi dấu ,">{{ old('meta_keywords') }}</textarea>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="meta_description" rows="2" class="form-control" 
                                                  placeholder="Mô tả ngắn cho SEO">{{ old('meta_description') }}</textarea>
                                    </div>
                                </div>

                                <div class="mb-3 w-25">
                                    <label class="form-label required">Trạng thái</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Đang hiển thị</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Chờ duyệt</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Nút submit --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i> Đăng tin ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .required:after {
        content: " *";
        color: #dc3545;
    }
    .preview-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .preview-item {
        position: relative;
        width: 100px;
        height: 100px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow: hidden;
        padding: 5px;
        background: #f8f9fa;
    }
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-item .delete-image {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 20px;
        height: 20px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 20px;
        cursor: pointer;
        font-size: 12px;
        display: none;
    }
    .preview-item:hover .delete-image {
        display: block;
    }
    .preview-item .check-avatar {
        position: absolute;
        bottom: 5px;
        left: 5px;
        font-size: 11px;
    }
    .preview-item .form-check-input {
        width: 12px;
        height: 12px;
    }
    .preview-item .form-check-label {
        font-size: 11px;
        color: #666;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Datepicker cho thời gian đăng
    $('#publicAt').daterangepicker({
        drops: 'up',
        autoUpdateInput: false,
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: true,
        timePickerSeconds: true,
        locale: {
            format: 'DD/MM/YYYY HH:mm:ss',
            applyLabel: 'Áp dụng',
            cancelLabel: 'Hủy',
            daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']
        }
    });
    
    $('#publicAt').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY HH:mm:ss'));
    });
    
    $('#publicAt').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    
    // Xử lý upload ảnh (tham khảo từ page)
    $('.upload-images').on('change', function() {
        let limit = 10;
        let files = $(this)[0].files;
        let countItems = $('.preview-images .preview-item').length;
        let space = limit - countItems;

        if (files.length > space) {
            alert(`Chỉ được chọn tối đa ${limit} hình ảnh`);
            this.value = '';
            return false;
        }

        for(const file of files) {
            // Kiểm tra file trùng
            if ($(`.preview-images .preview-item[data-file="${file.name}"]`).length > 0) {
                alert(`Hình ảnh có tên tương tự đã được thêm!`);
                continue;
            }
            
            let reader = new FileReader();
            reader.onload = function() {
                let index = $('.preview-images .preview-item').length;
                let isFirstImage = index === 0; // Ảnh đầu tiên làm đại diện

                let previewHTML = `<div class="preview-item" data-file="${file.name}">`;
                previewHTML += `<input type="file" name="images[]" class="d-none" />`;
                previewHTML += `<img src="${reader.result}">`;
                previewHTML += `<div class="form-check check-avatar">`;
                previewHTML += `<input class="form-check-input" type="radio" name="is_avatar" id="cbav${index}" value="${file.name}" ${isFirstImage ? 'checked' : ''}>`;
                previewHTML += `<label class="form-check-label" for="cbav${index}">Ảnh đại diện</label>`;
                previewHTML += `</div>`;
                previewHTML += `<span class="delete-image"><i class="fas fa-times"></i></span>`;
                previewHTML += `</div>`;
                
                $('.preview-images').append(previewHTML);

                // Lưu file vào input ẩn
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.querySelector(`.preview-item[data-file="${file.name}"] input[name="images[]"]`).files = dataTransfer.files;
                
                // Cập nhật hidden field cho ảnh đại diện
                if (isFirstImage) {
                    $('input[name="is_avatar"]').val(file.name);
                }
            };
            reader.readAsDataURL(file);
        }

        $('.preview-images').css('display', 'flex');
    });

    // Xóa ảnh preview
    $(document).on('click', '.preview-item .delete-image', function() {
        $(this).closest('.preview-item').remove();
        let countItems = $('.preview-images .preview-item').length;
        if (countItems <= 0) {
            $('.preview-images').css('display', 'none');
        }
        
        // Nếu xóa ảnh đại diện, chọn ảnh đầu tiên làm đại diện
        if ($('input[name="is_avatar"]:checked').length === 0 && countItems > 0) {
            $('.preview-images .preview-item:first-child input[name="is_avatar"]').prop('checked', true);
            let fileName = $('.preview-images .preview-item:first-child').data('file');
            $('input[name="is_avatar"]').val(fileName);
        }
    });

    // Thay đổi ảnh đại diện
    $(document).on('change', 'input[name="is_avatar"]', function() {
        let fileName = $(this).val();
        $('input[name="is_avatar"]').val(fileName);
    });

    // Validation
    $("#listingForm").validate({
        rules: {
            name: "required",
            category_id: "required",
            type: "required",
            price: "required",
            area: "required",
            location: "required",
            content: "required",
            status: "required"
        },
        messages: {
            name: "Vui lòng nhập tiêu đề",
            category_id: "Vui lòng chọn loại BĐS",
            type: "Vui lòng chọn hình thức",
            price: "Vui lòng nhập giá",
            area: "Vui lòng nhập diện tích",
            location: "Vui lòng nhập địa chỉ",
            content: "Vui lòng nhập mô tả",
            status: "Vui lòng chọn trạng thái"
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
@endpush
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chỉnh sửa tin đăng: {{ $listing->name }}</h5>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    
                    <form action="{{ route('listing.update', $listing->id) }}" method="POST" enctype="multipart/form-data" id="listingForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12">
                                {{-- Thông tin cơ bản --}}
                                <div class="mb-3">
                                    <label class="form-label required">Tiêu đề tin đăng</label>
                                    <input type="text" class="form-control" name="name" 
                                           value="{{ old('name', $listing->name) }}" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Loại bất động sản</label>
                                        <select class="form-control select2" name="category_id" required>
                                            <option value="">Chọn loại bất động sản</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Hình thức</label>
                                        <select class="form-control select2" name="type" required>
                                            <option value="">Chọn hình thức</option>
                                            <option value="sale" {{ old('type', $listing->type) == 'sale' ? 'selected' : '' }}>Cần bán</option>
                                            <option value="rent" {{ old('type', $listing->type) == 'rent' ? 'selected' : '' }}>Cho thuê</option>
                                            <option value="buy" {{ old('type', $listing->type) == 'buy' ? 'selected' : '' }}>Cần mua</option>
                                            <option value="rental" {{ old('type', $listing->type) == 'rental' ? 'selected' : '' }}>Cần thuê</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Giá</label>
                                        <input type="text" class="form-control" name="price" 
                                               value="{{ old('price', $listing->price) }}" required>
                                        <small class="form-text text-muted">Nhập giá bằng chữ</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Diện tích (m²)</label>
                                        <input type="text" class="form-control" name="area" 
                                               value="{{ old('area', $listing->area) }}" required>
                                        <small class="form-text text-muted">Nhập diện tích bằng số</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required">Địa chỉ</label>
                                    <input type="text" class="form-control" name="location" 
                                           value="{{ old('location', $listing->location) }}" required>
                                </div>
                                
                                {{-- Mô tả --}}
                                <div class="mb-3">
                                    <label class="form-label">Nội dung ngắn</label>
                                    <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt', $listing->excerpt) }}</textarea>
                                </div>

                                {{-- Hình ảnh --}}
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Hình ảnh (có thể chọn nhiều)</label>
                                    <input class="form-control upload-images" type="file" id="formFile" accept="image/*" multiple>
                                    
                                    {{-- Hiển thị ảnh hiện tại --}}
                                    @if($listing->images && $listing->images->count() > 0)
                                    <div class="current-images mt-3">
                                        <p class="small mb-2">Ảnh hiện có:</p>
                                        <div class="preview-images" style="display: flex;">
                                            @foreach($listing->images as $image)
                                            <div class="preview-item" data-file="{{ $image->name }}" data-id="{{ $image->id }}">
                                                <img src="{{ asset($image->image) }}">
                                                <div class="form-check check-avatar">
                                                    <input class="form-check-input" type="radio" name="is_avatar" 
                                                           id="cbcurrent{{ $image->id }}" 
                                                           value="{{ $image->name }}"
                                                           {{ $image->is_avatar ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cbcurrent{{ $image->id }}">
                                                        Ảnh đại diện
                                                    </label>
                                                </div>
                                                <span class="delete-image"></span>
                                            </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="removeImages" id="removeImages">
                                    </div>
                                    @endif
                                    
                                    {{-- Preview ảnh mới --}}
                                    <div class="new-images-preview preview-images mt-3" style="display: none;"></div>
                                    
                                    <input type="hidden" name="is_avatar" value="{{ $listing->images->where('is_avatar', 1)->first()->name ?? '' }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required">Mô tả chi tiết</label>
                                    <textarea name="content" rows="6" class="form-control tinymce">{{ old('content', $listing->content) }}</textarea>
                                </div>
                                
                                {{-- SEO --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Keywords</label>
                                        <textarea name="meta_keywords" rows="2" class="form-control">{{ old('meta_keywords', $listing->meta_keywords) }}</textarea>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="meta_description" rows="2" class="form-control">{{ old('meta_description', $listing->meta_description) }}</textarea>
                                    </div>
                                </div>

                                <div class="mb-3 w-25">
                                    <label class="form-label required">Trạng thái</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ old('status', $listing->status) == 1 ? 'selected' : '' }}>Đang hiển thị</option>
                                        <option value="0" {{ old('status', $listing->status) == 0 ? 'selected' : '' }}>Chờ duyệt</option>
                                        <option value="2" {{ old('status', $listing->status) == 2 ? 'selected' : '' }}>Từ chối</option>
                                        <option value="3" {{ old('status', $listing->status) == 3 ? 'selected' : '' }}>Hết hạn</option>
                                    </select>
                                </div>
                            </div>
                            
                           
                        </div>
                        
                        {{-- Nút submit --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save me-2"></i> Cập nhật
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
    
    // Xử lý upload ảnh mới
    $('.upload-images').on('change', function() {
        let limit = 10;
        let files = $(this)[0].files;
        let countCurrentItems = $('.current-images .preview-item').length;
        let countNewItems = $('.new-images-preview .preview-item').length;
        let countItems = countCurrentItems + countNewItems;
        let space = limit - countItems;

        if (files.length > space) {
            alert(`Chỉ được upload tối đa ${limit} hình ảnh (hiện có ${countItems} ảnh)`);
            this.value = '';
            return false;
        }

        for(const file of files) {
            // Kiểm tra file trùng
            if ($(`.preview-item[data-file="${file.name}"]`).length > 0) {
                alert(`Hình ảnh có tên tương tự đã được thêm!`);
                continue;
            }
            
            let reader = new FileReader();
            reader.onload = function() {
                let index = $('.new-images-preview .preview-item').length;

                let previewHTML = `<div class="preview-item" data-file="${file.name}">`;
                previewHTML += `<input type="file" name="images[]" class="d-none" />`;
                previewHTML += `<img src="${reader.result}">`;
                previewHTML += `<div class="form-check check-avatar">`;
                previewHTML += `<input class="form-check-input" type="radio" name="is_avatar" id="cbnew${index}" value="${file.name}">`;
                previewHTML += `<label class="form-check-label" for="cbnew${index}">Ảnh đại diện</label>`;
                previewHTML += `</div>`;
                previewHTML += `<span class="delete-image"></span>`;
                previewHTML += `</div>`;
                
                $('.new-images-preview').append(previewHTML);
                $('.new-images-preview').css('display', 'flex');

                // Lưu file vào input ẩn
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.querySelector(`.new-images-preview .preview-item[data-file="${file.name}"] input[name="images[]"]`).files = dataTransfer.files;
            };
            reader.readAsDataURL(file);
        }
    });

    // Xóa ảnh preview mới
    $(document).on('click', '.new-images-preview .delete-image', function() {
        $(this).closest('.preview-item').remove();
        let countItems = $('.new-images-preview .preview-item').length;
        if (countItems <= 0) {
            $('.new-images-preview').css('display', 'none');
        }
    });

    // Xóa ảnh hiện tại
    $(document).on('click', '.current-images .delete-image', function(e) {
        e.preventDefault();
        
        // if (confirm('Xóa ảnh này?')) {
            let item = $(this).closest('.preview-item');
            let imageId = item.data('id');
            
            // Thêm ID vào danh sách xóa
            let removeImages = $('#removeImages').val();
            let removeArray = removeImages ? removeImages.split(',') : [];
            if (!removeArray.includes(imageId.toString())) {
                removeArray.push(imageId);
                $('#removeImages').val(removeArray.join(','));
            }
            
            // Ẩn ảnh
            item.hide();
        // }
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
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm dự án
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="">Danh mục</label>
                            <select class="form-control select2" name="category_id">
                                <option value="">- Không có -</option>
                                @foreach($categories as $key => $item)
                                    @include('admin.project-category.includes.option', ['category' => $item, 'full' => 1])
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="required">Tên dự án</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label>Slogan</label>
                            <input type="text" class="form-control" name="slogan">
                        </div>
                        <div class="mb-3">
                            <label>Giá</label>
                            <input type="text" class="form-control" name="price" value="">
                        </div>
                        <div class="mb-3">
                            <label>Vị trí</label>
                            <input type="text" class="form-control" name="position" value="">
                        </div>
                        <div class="mb-3">
                            <label>Mô tả ngắn</label>
                            <textarea name="excerpt" rows="4" class="form-control" id=""></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Logo dự án</label>
                            <input type="file" class="form-control" name="logo">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh (có thể chọn nhiều)</label>
                            <input class="form-control upload-images" type="file" id="formFile" accept="image/*" multiple>
                            <div class="preview-images"></div>
                            <input type="hidden" name="isAvatar">
                        </div>
                        <div class="mb-3 row">
                           <div class="col-md-6">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control select2">
                                    <option value="1">Kích hoạt</option>
                                    <option value="0">Không kích hoạt</option>
                                </select>
                           </div>
                        </div>
                        <div class="mb-3 pt-3 border-top">
                            <button type="button" class="btn btn-primary add-page-block">Thêm khối</button>
                        </div>
                        <div class="mb-3 page-blocks"></div>

                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="page-block-layout" class="d-none">
    <div class="page-block-item border rounded mt-3 p-3">
        <span class="delete-page-block"></span>
        <div class="mb-3">
            <label class="form-label">Tên khối</label>
            <input class="form-control" type="text" name="block_name[]">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Hình nền khối</label>
            <input class="form-control" type="file" id="formFile" name="block_image[]" accept="image/*">
            <img class="preview-image w-25 mt-2 rounded d-none">
        </div>
        <div>
            <label>Nội dung</label>
            <textarea name="block_content[]" rows="4" class="form-control" ></textarea>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    $(document).ready(function() {
        
        $("form").validate({
            rules: {
                // "category_id": {
                //     required: true,
                // },
                "name": {
                    required: true,
                },
            }
        });
    });

    $('.upload-images').on('change', function() {

        let limit = 10;
        let files = $(this)[0].files;
        let countItems = $('.preview-images .preview-item').length;
        let space = limit - countItems;

        if (files.length > space) {
            alert(`Chỉ được chọn tối đa ${limit} hình ảnh`);
            return false;
        }

        for(const file of files) {

            if ($(`.preview-images .preview-item[data-file="${file.name}"]`).length > 0) {
                alert(`Hình ảnh có tên tương tự đã được thêm!`);
                return false;
            }
            
            let reader = new FileReader();
            reader.onload = function(){

                let index = $('.preview-images .preview-item').length;

                let previewHTML = `<div class="rounded preview-item" data-file="${file.name}">`
                    previewHTML += `<input type="file" name="images[]" class="d-none" />`
                    previewHTML += `<img src="${reader.result}">`
                    previewHTML += `<div class="form-check check-avatar">`
                    previewHTML += `<input class="form-check-input" type="radio" name="is_avatar" id="cbav${index}" value="${file.name}">`
                    previewHTML += `<label class="form-check-label" for="cbav${index}">Đặt làm đại diện</label>`
                    previewHTML += `</div>`
                    previewHTML += `<span class="delete-image"></span>`
                    previewHTML += `</div>`;
                
                $('.preview-images').append(previewHTML);

                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.querySelector(`.preview-item[data-file="${file.name}"] input[name="images[]"]`).files = dataTransfer.files;
            };
            reader.readAsDataURL(file);
        }

        $('.preview-images').css('display', 'flex');
    });

    $(document).on('click', '.preview-item .delete-image', function() {
        $(this).closest('.preview-item').remove();
        let countItems = $('.preview-images .preview-item').length;
        if (countItems <= 0) {
            $('.preview-images').css('display', 'none');
        }
    });

    $('.add-page-block').click(function() {

        let item = $('#page-block-layout .page-block-item').clone();
        let uniqueClass = 'page-block-item-' + new Date().getTime();
        item.addClass(uniqueClass)
        $('.page-blocks').append(item);

        let itemSeletor = '.' + uniqueClass + ' textarea';
        initTinymce(itemSeletor)
    })

    $(document).on('click', '.page-block-item .delete-page-block', function() {
        $(this).closest('.page-block-item ').remove();
    });

</script>
@endpush

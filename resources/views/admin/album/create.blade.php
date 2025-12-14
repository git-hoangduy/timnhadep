@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm album
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-9">
                                <label class="required">Tên album</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="col-3">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control select2">
                                    <option value="1">Kích hoạt</option>
                                    <option value="0">Không kích hoạt</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Mô tả ngắn</label>
                            <textarea name="content" rows="4" class="form-control tinymce" ></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh (có thể chọn nhiều)</label>
                            <input class="form-control upload-images" type="file" id="formFile" accept="image/*" multiple>
                            <div class="preview-images"></div>
                            <input type="hidden" name="isAvatar">
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

    $("form").validate({
		rules: {
			"name": {
				required: true,
			},
		}
	});

    $('.upload-images').on('change', function() {

        let limit = 100;
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

                let previewHTML = `<div class="preview-item" data-file="${file.name}">`
                    previewHTML += `<input type="file" name="images[]" class="d-none" />`
                    previewHTML += `<img src="${reader.result}">`
                    previewHTML += `<div class="form-check check-avatar">`
                    previewHTML += `<input class="form-check-input" type="radio" name="is_avatar" id="cbav${index}" value="${file.name}">`
                    previewHTML += `<label class="form-check-label" for="cbav${index}">Ảnh đại diện</label>`
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
</script>
@endpush

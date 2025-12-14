@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa album
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('album.update', $album->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3 row">
                            <div class="col-9">
                                <label class="required">Tên trang</label>
                                <input type="text" class="form-control" name="name" value="{{ $album->name }}">
                            </div>
                            <div class="col-3">
                                <label class="required">Trạng thái</label>
                                <select name="status" class="form-control select2">
                                    <option value="1" {{ $album->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ $album->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Mô tả ngắn</label>
                            <textarea name="content" rows="4" class="form-control tinymce" >{!! $album->content !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh (có thể chọn nhiều)</label>
                            <input class="form-control upload-images" type="file" id="formFile" accept="image/*" multiple>
                            <div class="preview-images" style="display: {{ $album->images->count() ? 'flex' : 'none' }}">
                                @foreach($album->images as $key => $image)
                                    <div class="preview-item" data-id="{{ $image->id }}" data-file="{{ $image->name }}">
                                        <img src="{{ asset($image->image) }}">
                                        <div class="form-check check-avatar">
                                            <input class="form-check-input" type="radio" name="is_avatar" id="cbav{{ $key }}" value="{{ $image->name }}" {{ $image->is_avatar == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cbav{{ $key }}">Ảnh đại diện</label>
                                        </div>
                                        <span class="delete-image"></span>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="removeImages">
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
        let limit = 10;
        let files = $(this)[0].files;
        let countItems = $('.preview-images .preview-item').length;
        let space = limit - countItems;

        if (files.length > space) {
            alert(`Chỉ được chọn tối đa ${limit} hình ảnh!`);
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

        let imageId = $(this).closest('.preview-item').attr('data-id');
        if (imageId) {
            let removeImages = $('input[name="removeImages"]').val().split(",");
            removeImages.push(imageId);
            $('input[name="removeImages"]').val(removeImages.join(","));
        }

        $(this).closest('.preview-item').remove();

        let countItems = $('.preview-images .preview-item').length;
        if (countItems <= 0) {
            $('.preview-images').css('display', 'none');
        }
    });
</script>
@endpush

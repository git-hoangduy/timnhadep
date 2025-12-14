@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa dự án
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('project.update', $project->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Danh mục</label>
                            <select class="form-control select2" name="category_id" required>
                                <option value="">- Không có -</option>
                                @foreach($categories as $key => $item)
                                    @include('admin.project-category.includes.option', ['category' => $item, 'selected' => $project->category_id, 'full' => 1])
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="required">Tên dự án</label>
                            <input type="text" class="form-control" name="name" value="{{ $project->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh (tối đa 10 hình)</label>
                            <input class="form-control upload-images" type="file" id="formFile" accept="image/*" multiple>
                            <div class="preview-images" style="display: {{ $project->images->count() ? 'flex' : 'none' }}">
                                @foreach($project->images as $key => $image)
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
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="required">Trạng thái</label>
                                <select name="status" class="form-control select2">
                                    <option value="1" {{ $project->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ $project->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 pt-3 border-top">
                            <button type="button" class="btn btn-primary add-page-block">Thêm khối</button>
                        </div>
                        <div class="mb-3 page-blocks">
                            @foreach($project->blocks as $key => $block)
                                <div class="page-block-item border rounded mt-3 p-3" data-id="{{ $block->id }}">
                                    <input type="hidden" name="block_id[]" value="{{ $block->id }}">
                                    <span class="delete-page-block"></span>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Hình nền khối</label>
                                        <input class="form-control" type="file" id="formFile" name="block_image[]" accept="image/*">
                                        <img class="preview-image w-25 mt-2 rounded d-none">
                                        @if ($block->block_image != '')
                                            <img class="preview-image w-25 mt-2 rounded" src="{{ asset($block->block_image) }}">
                                        @else
                                            <img class="preview-image w-25 mt-2 rounded d-none">
                                        @endif
                                    </div>
                                    <div>
                                        <label>Nội dung</label>
                                        <textarea name="block_content[]" rows="4" class="form-control tinymce" >{!!  $block->block_content !!}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="removeBlocks">
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="page-block-layout" class="d-none">
    <div class="page-block-item border rounded mt-3 p-3">
        <input type="hidden" name="block_id[]">
        <span class="delete-page-block"></span>
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

                let previewHTML = `<div class="rounded preview-item" data-file="${file.name}">`
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

    
    $(document).on('click', '.page-block-item .delete-page-block', function() {

        let blockId = $(this).closest('.page-block-item').attr('data-id');
        if (blockId) {
            let removeBlocks = $('input[name="removeBlocks"]').val().split(",");
            removeBlocks.push(blockId);
            $('input[name="removeBlocks"]').val(removeBlocks.join(","));
        }

        $(this).closest('.page-block-item ').remove();
    });

</script>
@endpush

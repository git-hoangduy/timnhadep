@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa bài mua bán
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('post.update',$post->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Danh mục</label>
                            <select class="form-control select2" name="category_id">
                                <option value="">- Không có -</option>
                                @foreach($categories as $key => $item)
                                    @include('admin.post-category.includes.option', ['category' => $item, 'selected' => $post->category_id, 'full' => 1])
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="required">Tên bài mua bán</label>
                            <input type="text" class="form-control" name="name" value="{{ $post->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh</label>
                            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                            @if ($post->image != '')
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset($post->image) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Nội dung ngắn</label>
                            <textarea name="excerpt" rows="4" class="form-control" >{!! $post->excerpt !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Nội dung bài mua bán</label>
                            <textarea name="content" rows="4" class="form-control tinymce">{!! $post->content !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Meta keywords (SEO)</label>
                            <textarea name="meta_keywords" rows="4" class="form-control" placeholder="Mỗi từ khóa cách nhau bởi dấu ,">{{ $post->meta_keywords }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Meta description (SEO)</label>
                            <textarea name="meta_description" rows="4" class="form-control">{{ $post->meta_description }}</textarea>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control select2">
                                    <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Thời gian tự đăng bài (Để trống để đăng ngay lặp tức)</label>
                                <input type="text" class="form-control" name="public_at" value="{{ date('d/m/Y H:i:s', strtotime($post->public_at)) }}" autocomplete="off">
                            </div>
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
    $(document).ready(function() {

        $("form").validate({
            rules: {
                "category_id": {
                    required: true,
                },
                "name": {
                    required: true,
                },
            }
        });

        $('[name="public_at"]').daterangepicker({
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
                daysOfWeek: ['CN', 'T.2', 'T.3', 'T.4', 'T.5', 'T.6', 'T.7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']
            }
        });

        $('[name="public_at"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY HH:mm:ss'));
        });

        $('[name="public_at"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endpush

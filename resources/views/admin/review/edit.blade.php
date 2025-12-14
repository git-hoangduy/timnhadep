@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa đánh giá
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('review.update',$review->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Tên đánh giá</label>
                            <input type="text" class="form-control" name="name" value="{{ $review->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh</label>
                            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                            @if ($review->image != '')
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset($review->image) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Mô tả ngắn</label>
                            <textarea name="content" rows="4" class="form-control tinymce" >{!! $review->content !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1" {{ $review->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ $review->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                            </select>
                        </div>
                        <div class="mt-5">
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
</script>
@endpush


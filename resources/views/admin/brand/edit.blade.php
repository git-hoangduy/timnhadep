@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa thương hiệu
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('brand.update',$brand->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Tên thương hiệu</label>
                            <input type="text" class="form-control" name="name" value="{{ $brand->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh</label>
                            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                            @if ($brand->image != '')
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset($brand->image) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                            </select>
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
</script>
@endpush

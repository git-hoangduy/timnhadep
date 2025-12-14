@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm footer
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('footer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="required">Tên footer</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label>Nội dung</label>
                            <textarea name="content" rows="4" class="form-control tinymce"></textarea>
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
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Lưu lại</button>
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
			"name": {
				required: true,
			},
		}
	});
});
    
</script>
@endpush

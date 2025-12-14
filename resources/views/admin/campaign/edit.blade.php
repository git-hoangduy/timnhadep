@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa chiến dịch
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('campaign.update', $campaign->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Tên chiến dịch</label>
                            <input type="text" class="form-control" name="name" value="{{ $campaign->name }}">
                        </div>
                        <div class="mb-3">
                            <label>Nội dung trang</label>
                            <textarea name="content" rows="4" class="form-control tinymce" >{!! $campaign->content !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1" {{ $campaign->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ $campaign->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
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

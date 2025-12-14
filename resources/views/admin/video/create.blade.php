@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm Video
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form id="formVideo" action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="required">Tên video</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label class="required">Link Youtube</label>
                            <input type="text" class="form-control" name="link">
                        </div>
                        <div class="mb-3">
                            <label class="required">Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1">Kích hoạt</option>
                                <option value="0">Không kích hoạt</option>
                            </select>
                        </div>
                        <div class="mb-3">
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
    $("#formVideo").validate({
        rules: {
            name: "required",
            link: "required",
        },
        messages: {
            name: 'Chưa nhập tên video',
            link: 'Chưa nhập link video',
        },
    });
</script>
@endpush
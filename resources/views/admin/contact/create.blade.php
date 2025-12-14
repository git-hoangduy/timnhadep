@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm chiến dịch
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">Quay lại</a>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{ route('campaign.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="required">Tên chiến dịch</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label>Nội dung trang</label>
                            <textarea name="content" rows="4" class="form-control tinymce" ></textarea>
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

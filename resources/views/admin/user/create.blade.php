@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm người dùng
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="required">Tên người dùng</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-6">
                                <label class="required">Email <small class="text-muted">(Sử dụng để đăng nhập)</small></label>
                                <input type="text" class="form-control" name="email">
                            </div>
                            <div class="col-6">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-6">
                                <label class="required">Mật khẩu</small></label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="col-6">
                                <label class="required">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="password_confirmation">
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
    $("form").validate({
		rules: {
			"name": {
				required: true,
			},
            "email": {
				required: true,
                email: true,
			},
            "password": {
                minlength: 6,
				required: true,
			},
            "password_confirmation": {
                required: true,
                minlength: 6,
                equalTo: "#password"
            }
		}
	});
</script>
@endpush
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="card">
                    <div class="card-header">Thay đổi mật khẩu</div>

                    <form action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            
                            @include('admin.includes.notification')

                            <div class="mb-3">
                                <label for="oldPasswordInput" class="required">Mật khẩu hiện tại</label>
                                <input name="old_password" type="password" class="form-control" id="old_password"
                                    placeholder="Nhập mật khẩu hiện tại">
                            </div>
                            <div class="mb-3">
                                <label for="newPasswordInput" class="required">Mật khẩu mới</label>
                                <input name="new_password" type="password" class="form-control" id="new_password"
                                    placeholder="Nhập mật khẩu mới">
                            </div>
                            <div class="mb-3">
                                <label for="confirmNewPasswordInput" class="required">Xác nhận mật khẩu mới</label>
                                <input name="new_password_confirmation" type="password" class="form-control" id="new_password_confirmation"
                                    placeholder="Nhập lại mật khẩu mới">
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-success" type="submit">Cập nhật</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $("form").validate({
		rules: {
			"old_password": {
				required: true,
			},
            "new_password": {
                minlength: 6,
				required: true,
			},
            "new_password_confirmation": {
                minlength: 6,
				required: true,
                equalTo: "#new_password"
			},
		}
	});
</script>
@endpush
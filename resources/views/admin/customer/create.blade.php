@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <!-- <div class="card-header d-flex justify-content-between">
                    Thêm khách hàng
                </div> -->
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="required">Tên người đăng ký</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="required">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                            <div class="col-md-4">
                                <label>Số điện thoại khác</label>
                                <input type="text" class="form-control" name="phone_extra">
                            </div>
                            <div class="col-md-4">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Địa chỉ chi tiết</label>
                            <input type="text" class="form-control" name="address">
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
            "phone": {
				required: true,
			},
		}
	});
</script>
@endpush
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa khách hàng
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('customer.update', $customer->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Tên khách hàng</label>
                            <input type="text" class="form-control" name="name" value="{{ $customer->name }}">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="required">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" value="{{ $customer->phone }}">
                            </div>
                            <div class="col-md-4">
                                <label>Số điện thoại khác</label>
                                <input type="text" class="form-control" name="phone_extra" value="{{ $customer->phone_extra }}">
                            </div>
                            <div class="col-md-4">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $customer->email }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Địa chỉ chi tiết</label>
                            <input type="text" class="form-control" name="address" value="{{ $customer->address }}">
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
            "phone": {
				required: true,
			},
		}
	});
</script>
@endpush
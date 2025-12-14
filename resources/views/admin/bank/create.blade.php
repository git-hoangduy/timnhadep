@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thêm tài khoản ngân hàng
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{ route('bank.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="required">Tên ngân hàng</label>
                            <input type="text" class="form-control" name="bank_name">
                        </div>
                        <div class="mb-3">
                            <label class="required">Tên tài khoản</label>
                            <input type="text" class="form-control" name="account_name">
                        </div>
                        <div class="mb-3">
                            <label class="required">Số tài khoản</label>
                            <input type="text" class="form-control" name="account_number">
                        </div>
                        <div class="mb-3">
                            <label class="required">Chi nhánh ngân hàng</label>
                            <input type="text" class="form-control" name="bank_address">
                        </div>
                        <div class="mb-3">
                            <label for="formFile">Hình ảnh</label>
                            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                            <img class="preview-image w-25 mt-2 rounded d-none">
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1">Kích hoạt</option>
                                <option value="0">Không kích hoạt</option>
                            </select>
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
			"bank_name": {
				required: true,
			},
            "account_name": {
				required: true,
			},
            "account_number": {
				required: true,
			},
            "bank_address": {
				required: true,
			},
		}
	});
</script>
@endpush

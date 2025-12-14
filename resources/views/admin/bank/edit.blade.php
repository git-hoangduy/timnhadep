@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa tài khoản ngân hàng
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('bank.update', $bank->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Tên ngân hàng</label>
                            <input type="text" class="form-control" name="bank_name" value="{{ $bank->bank_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="required">Tên tài khoản</label>
                            <input type="text" class="form-control" name="account_name" value="{{ $bank->account_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="required">Số tài khoản</label>
                            <input type="text" class="form-control" name="account_number" value="{{ $bank->account_number }}">
                        </div>
                        <div class="mb-3">
                            <label class="required">Chi nhánh ngân hàng</label>
                            <input type="text" class="form-control" name="bank_address" value="{{ $bank->bank_address }}">
                        </div>
                        <div class="mb-3">
                            <label for="formFile">Hình ảnh</label>
                            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                            @if ($bank->image != '')
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset($bank->image) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1" {{ $bank->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ $bank->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
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


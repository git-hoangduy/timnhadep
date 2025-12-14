@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa mã giảm giá
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('coupon.update', $coupon->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Tên mã giảm giá (CTKM)</label>
                            <input type="text" class="form-control" name="name" value="{{ $coupon->name }}">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-9">
                                <label class="required">Mã giảm giá</label>
                                <input type="text" class="form-control" name="code" value="{{ $coupon->code }}">
                            </div>
                            <div class="col-md-3">
                                <label class="d-block">&nbsp;</label>
                                <button type="button" class="btn btn-primary randomCouponCode">Tạo ngẫu nhiên</button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="required">Loại giảm giá</label>
                                <select name="type" class="form-control select2">
                                    <option value="1" {{ $coupon->type == '1' ? 'selected' : '' }}>Giảm theo số tiền</option>
                                    <option value="2" {{ $coupon->type == '2' ? 'selected' : '' }}>Giảm theo phần trăm</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="required">Giá trị</label>
                                <input type="text" class="form-control" name="value" value="{{ $coupon->value }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label>Ngày bắt đầu</label>
                                <input type="text" class="form-control" name="start_date" value="{{ $coupon->start_date }}">
                            </div>
                            <div class="col-md-6">
                                <label>Ngày kết thúc</label>
                                <input type="text" class="form-control" name="end_date" value="{{ $coupon->end_date }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
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
            "code": {
				required: true,
			},
            "type": {
				required: true,
			},
            "value": {
				required: true,
			},
		}
	});
    $('.randomCouponCode').click(function() {
        let now = new Date();
        let seconds = Math.floor(now.getTime() / 1000);
        let code = 'C' + seconds;
        $('input[name="code"]').val(code);
    });
    $('select[name="type"]').change(function() {
        $('input[name="value"]').val('');
    });
</script>
@endpush

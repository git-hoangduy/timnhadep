@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('attribute.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                @include('admin.includes.notification')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Thêm thuộc tính
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="required">Tên thuộc tính</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label class="required">Loại thuộc tính</label>
                            <select name="type" class="form-control select2">
                                <option value="1">Text</option>
                                <option value="2">Color</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1">Kích hoạt</option>
                                <option value="0">Không kích hoạt</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="" class="mb-2">Thêm giá trị</label>
                            <div class="mb-3 values"></div>
                            <div class="mb-3">
                                <button class="btn btn-sm btn-primary addValue" type="button">Thêm giá trị</button>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Lưu lại</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="d-none">
    <div class="value value-color mb-3 row">
        <input type="hidden" value="" name="id[]">
        <div class="col-md-8">
            <input type="text" class="form-control" name="text[]" placeholder="Nhập tên">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="color[]" placeholder="Chọn màu (HEX)">
        </div>
        <div class="col-md-1">
            <button class="btn btn-danger deleteValue"><i class="fas fa-trash"></i></button>
        </div>
    </div>
    <div class="value value-text mb-3 row">
        <input type="hidden" value="" name="id[]">
        <div class="col-md-8">
            <input type="text" class="form-control" name="text[]" placeholder="Nhập tên">
        </div>
        <div class="col-md-1">
            <button class="btn btn-danger deleteValue"><i class="fas fa-trash"></i></button>
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

    $('select[name="type"]').change(function() {
        $('.values').empty();
    })

    $('.addValue').click(function() {
        var type = $('select[name="type"]').val();
        if (type == 1) {

            var item = $('.d-none .value.value-text').clone();
            $('.values').append(item);

        } else {

            var item = $('.d-none .value.value-color').clone();
            $('.values').append(item);
            
            var __class = 'color-input-' + $('.values .value').length;
            item.find('input[name="color[]"]').addClass(__class);
            var color = new Huebee('.' + __class, {
                setBGColor: true,
                saturations: 2,
                notation: 'hex',
            });
        }
    })

    $(document).on('click', '.deleteValue', function() {
        $(this).closest('.value').remove();
    })

</script>
@endpush

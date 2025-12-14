@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.includes.notification')
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Tạo đơn hàng
                    </div>
                    <div class="card-body">
                        @include('admin.includes.notification')
                        <div class="mb-3 row">
                            <div class="col-6">
                                <label class="required">Tên khách hàng</label>
                                <input type="text" class="form-control" name="customer_name">
                                <input type="hidden" class="form-control" name="customer_id">
                            </div>
                            <div class="col-6">
                                <label for="">Chọn từ khách hàng</label>
                                <select name="" class="form-control search-customer" name="product">
                                    {{-- <option value="">- Chọn khách hàng -</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="required">SĐT khách hàng</label>
                            <input type="text" class="form-control" name="customer_phone">
                        </div>
                        <div class="mb-3">
                            <label class="required">Địa khách hàng</label>
                            <input type="text" class="form-control" name="customer_address">
                        </div>
                        <div class="mb-3">
                            <label>Email khách hàng</label>
                            <input type="text" class="form-control" name="customer_email">
                        </div>
                        <div class="mb-3">
                            <label>Ghi chú</label>
                            <textarea name="note" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="required">Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="0">Đơn nháp</option>
                                <option value="1" selected>Đơn mới</option>
                                <option value="2">Đang vận chuyển</option>
                                <option value="3">Đã giao hàng</option>
                                <option value="4">Đã hủy</option>
                            </select>
                        </div>
                        <div class="mt-4 text-center">
                            <button class="btn btn-success" type="submit">Thêm đơn hàng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Chọn sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="required">Tìm kiếm sản phẩm</label>
                            <select class="form-control search-product" class="form-control" name="search_product">
                            </select>
                            <input type="hidden" name="selected_product">
                        </div>
                        <table class="table mb-3">
                            <thead>
                              <tr>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá bán</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng tiền</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody class="product-list">
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Tổng cộng</label>
                                <input type="text" name="amount" class="form-control fw-bold text-secondary" value="0" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>% Khuyến mãi (1-100)</label>
                                <input type="number" name="discount_percent" class="form-control fw-bold" min="0" max="100" value="0">
                            </div>
                            <div class="col-md-4">
                                <label>Tổng tiền thanh toán</label>
                                <input type="text" name="total" class="form-control fw-bold" value="0" readonly>
                                <input type="hidden" name="discount" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>

    $( document ).ready(function() {

        $('.search-customer').select2({
            language: {
                searching: function() {
                    return "Đang tìm kiếm ...";
                },
                inputTooShort: function() {
                    return 'Nhập từ khóa để tìm kiếm';
                },
                "noResults": function(){
                    return "Không có kết quả nào";
                }
            },
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("customer.search") }}',
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                }
            }
        });

        $('.search-product').select2({
            language: {
                searching: function() {
                    return "Đang tìm kiếm ...";
                },
                inputTooShort: function() {
                    return 'Nhập từ khóa để tìm kiếm';
                },
                "noResults": function(){
                    return "Không có kết quả mào";
                }
            },
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("product.search") }}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                }
            }
        });

        $("form").validate({
            ignore: [],
            rules: {
                "customer_name": {
                    required: true,
                },
                "customer_phone": {
                    required: true,
                },
                "customer_address": {
                    required: true,
                },
                "selected_product": {
                    selected_product: true
                }
            }
        });

        $.validator.addMethod("selected_product", function(value, element) {
            if ($('.product-list .product-item').length > 0) {
                return true;
            } else {
                return false;
            }
        }, "Bạn phải chọn ít nhất một sản phẩm");

        
    });

    $('.search-customer').change(function() {
        var customerId = $(this).val();
        $.ajax({
            url: '{{ route("customer.get") }}',
            data: {customerId: customerId},
            beforeSend: function() {
            },
            success: function(res){
                if(res && res.status == 'success') {
                    $('input[name="customer_id"]').val(res.data.id);
                    $('input[name="customer_name"]').val(res.data.name);
                    $('input[name="customer_phone"]').val(res.data.phone || res.data.phone_extra);
                    $('input[name="customer_address"]').val(res.data.address);
                    $('input[name="customer_email"]').val(res.data.email);
                }
            },
            complete: function() {
                $('.search-customer').val(null).trigger('change');
            },
        });
    })

    $('.search-product').change(function() {
        var productId = $(this).val();
        $.ajax({
            url: '{{ route("product.get") }}',
            data: {productId: productId},
            beforeSend: function() {
            },
            success: function(res){
                if(res && res.status == 'success') {

                    if ($(`.product-list .product-item[data-id="${res.data.id}"]`).length > 0) {
                        alert(`Sản phẩm "${res.data.name}" đã được thêm rồi`);
                        return;
                    }

                    var item = 
                    item += `<tr class="product-item" data-id="${res.data.id}">`
                    item +=     `<td width="50%" class="p-name"><input type="hidden" name="id[]" value="${res.data.id}"/>${res.data.name}</td>`
                    item +=     `<td width="15%" class="p-price"><input type="hidden" name="price[]" value="${res.data.price}"/>${numberWithCommas(res.data.price)}</td>`
                    item +=     `<td width="15%" class="p-quantity"><input type="number" name="quantity[]" min="0" class="form-control form-control-sm text-center" value="1" autocomplete="off"></td>`
                    item +=     `<td width="15%" class="p-amount"><i class="fa-solid fa-spinner fa-spin"></i></td>`
                    item +=     `<td width="5%">`
                    item +=         `<button type="button" class="btn btn-sm btn-danger delete">Xóa</button>`
                    item +=     `</td>`
                    item += `</tr>`;

                    $('.product-list').append(item);
                    $('.search-product').val('').trigger('change');
                    $('#selected_product-error').remove();
                    calculate();
                }
            }
        });
    })

    $(document).on('change', '.product-item .p-price input', function() {
        calculate();
    })

    $(document).on('click', '.product-item .delete', function() {
        $(this).closest('.product-item').remove();
        calculate();
    });

    $('input[name="discount_percent"]').change(function() {
        calculate();
    });

    function calculate() {
        let total = 0;
        $('.product-list .product-item').each(function(i, e) {
            let price = parseNumberFromString($(e).find('.p-price').text());
            let quantity = parseNumberFromString($(e).find('.p-quantity input').val());
            let amount = price*quantity;
            total = total + amount;
            $(e).find('.p-amount').text(numberWithCommas(amount));
        })

        let discountPercent = parseNumberFromString($('input[name="discount_percent"]').val());
        let discount = total * (discountPercent/100)

        $('input[name="amount"]').val(numberWithCommas(total));
        $('input[name="total"]').val(numberWithCommas(total - discount));
        $('input[name="discount"]').val(discount);
    }
    
</script>
@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Cập nhật đơn hàng
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">Quay lại</a>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('order.update', $order->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Trạng thái</label>
                            <select name="status" class="form-control select2" style="width: 100%">
                                <option value="">- Trạng thái -</option>
                                <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Đơn nháp</option>
                                <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đơn mới</option>
                                <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đang vận chuyển</option>
                                <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('order.create') }}" class="btn btn-success">Tạo đơn hàng</a>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    Lọc đơn hàng
                </div>
                <div class="card-body">
                    <form action="{{ route('order.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control" name="keyword" placeholder="Nhập từ khóa" value="{{ request()->keyword ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <select name="status" class="form-control select2" style="width: 100%">
                                        <option value="">- Trạng thái -</option>
                                        <option value="0" {{ request()->status && request()->status == 0 ? 'selected' : '' }}>Đơn nháp</option>
                                        <option value="1" {{ request()->status && request()->status == 1 ? 'selected' : '' }}>Đơn mới</option>
                                        <option value="2" {{ request()->status && request()->status == 2 ? 'selected' : '' }}>Đang vận chuyển</option>
                                        <option value="3" {{ request()->status && request()->status == 3 ? 'selected' : '' }}>Đã giao hàng</option>
                                        <option value="4" {{ request()->status && request()->status == 4 ? 'selected' : '' }}>Đã hủy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="{{ route('order.index') }}" class="btn btn-success">Làm mới</a>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Đơn hàng
                    <small class="text-secondary">{{ "Hiển thị " .  $orders->firstItem() . "-" . $orders->lastItem() . " của " . $orders ->total() . ' đơn hàng' }}</small>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($orders->count())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Khuyến mãi</th>
                                    <th scope="col">Thanh toán</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày mua</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $item->order_number }}</td>
                                        <td>
                                            <span class="d-block mb-1">
                                                <i class="bi bi-person-circle me-1 text-secondary"></i>
                                                {{ $item->customer_name }}
                                            </span>
                                            <span class="d-block">
                                                <i class="bi bi-telephone-fill me-1 text-secondary"></i>
                                                {{ $item->customer_phone }}
                                            </span>
                                        </td>
                                        <td><b>{{ number_format($item->amount) }}</b></td>
                                        <td><b>{{ number_format($item->discount) }}</b></td>
                                        <td><b>{{ number_format($item->total) }}</b></td>
                                        <td>
                                            @if($item->status == 0)
                                                <span class="badge rounded-pill bg-default">Đơn nháp</span>
                                            @elseif($item->status == 1)
                                                <span class="badge rounded-pill bg-secondary">Đơn mới</span>
                                            @elseif($item->status == 2)
                                                <span class="badge rounded-pill bg-primary">Đang vận chuyển</span>
                                            @elseif($item->status == 3)
                                                <span class="badge rounded-pill bg-success">Đã giao hàng</span>
                                            @elseif($item->status == 4)
                                                <span class="badge rounded-pill bg-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            {{-- <select class="changeStatus" data-id="{{ $item->id }}">
                                                <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Đơn nháp</option>
                                                <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Đơn mới</option>
                                                <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>Đang vận chuyển</option>
                                                <option value="3" {{ $item->status == 3 ? 'selected' : '' }}>Đã giao hàng</option>
                                                <option value="4" {{ $item->status == 4 ? 'selected' : '' }}>Đã hủy</option>
                                            </select> --}}
                                            <a href="{{ route('order.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                            <form action="{{ route('order.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                        @else
                        <p class="text-center">Không có kết quả nào.</p>
                        @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

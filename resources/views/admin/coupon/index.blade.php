@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('coupon.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Mã giảm giá
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($coupons->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mã giảm giá</th>
                                <th scope="col">Tên mã giảm giá (CTKM)</th>
                                <th scope="col">Loại giảm giá</th>
                                <th scope="col">Giá trị</th>
                                <th scope="col">Bắt đầu - Kết thúc</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($coupons as $item)
                                <tr>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if($item->type == 1)
                                            <span class="badge rounded-pill bg-primary">Giảm theo số tiền</span>
                                        @else
                                            <span class="badge rounded-pill bg-info">Giảm theo phần trăm</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->type == 1)
                                            {{ number_format($item->value) }} đ
                                        @else
                                            {{ $item->value }} %
                                        @endif
                                    </td>
                                    <td>{{ $item->start_date.' - '.$item->end_date }}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('coupon.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('coupon.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $coupons->links() }}
                    @else
                       <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

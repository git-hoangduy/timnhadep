@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('bank.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Danh sách tài khoản
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <h6 class="card-subtitle mb-4 text-muted">Thông tin tài khoản ngân hàng của cửa hàng trong trường hợp khách hàng thanh toán chuyển khoản.</h6>
                    @if ($banks->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên ngân hàng</th>
                                <th scope="col">Tên tài khoản</th>
                                <th scope="col">Số tài khoản</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banks as $item)
                            <tr>
                                <td>
                                    @if($item->image != '')
                                        <img src="{{ asset($item->image) }}" width="25" height="25">
                                    @else
                                        <img src="{{ asset('uploads/default.png') }}" width="25" height="25">
                                    @endif
                                </td>
                                <td>{{ $item->bank_name }}</td>
                                <td>{{ $item->account_name }}</td>
                                <td>{{ $item->account_number }}</td>
                                <td>
                                    @if($item->status == 1)
                                        <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                    @endif
                                </td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <a href="{{ route('bank.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                    <form action="{{ route('bank.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                       <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

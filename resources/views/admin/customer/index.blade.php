@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- <div class="mb-3">
                <a href="{{ route('customer.create') }}" class="btn btn-success">Thêm mới</a>
            </div> -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    Lọc người đăng ký
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="keyword" placeholder="Nhập tên người đăng ký, số điện thoại, email" value="{{ request()->keyword ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="{{ route('customer.index') }}" class="btn btn-success">Làm mới</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    người đăng ký
                    <small class="text-secondary">{{ "Hiển thị " .  $customers->firstItem() . "-" . $customers->lastItem() . " của " . $customers ->total() . ' người đăng ký' }}</small>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    @if ($customers->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên người đăng ký</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Số điện thoại khác</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ngày cập nhật</th>
                                <!-- <th scope="col">Thao tác</th> -->
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($customers as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->phone_extra }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td class="d-none">
                                        <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('customer.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $customers->links() }}
                    @else
                       <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

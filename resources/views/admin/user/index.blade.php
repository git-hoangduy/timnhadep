@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('user.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Người dùng
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-4 text-muted">Quản lý tài khoản đăng nhập của khách hàng trên Website</h6>
                    @include('admin.includes.notification')
                    @if ($users->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên người dùng</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($users as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                    @else
                       <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

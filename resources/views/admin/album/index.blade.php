@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('album.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Albums
                </div>
                <div class="card-body">

                    <h6 class="card-title text-secondary mb-3">Bạn có thể chèn mã Album vào bài viết để hiện thị Album trong nội dung bài viết.</h6>

                    @include('admin.includes.notification')

                    @if ($albums->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mã Album</th>
                                <th scope="col">Tên Album</th>
                                <th scope="col">Ảnh đại diện</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($albums as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if ($item->avatar)
                                            <img src="{{ asset($item->avatar->image) }}" width="30" height="30">
                                        @else
                                            <img src="{{ asset('uploads/default.png') }}" width="30" height="30">
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('album.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('album.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $albums->links() }}
                    @else
                       <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

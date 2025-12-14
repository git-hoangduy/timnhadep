@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('video.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Video
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($videos->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mã Video</th>
                                <th scope="col">Tên video</th>
                                <th scope="col">Video ID</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($videos as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->video_id }}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('video.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        @if ($item->id != 1)
                                            <form action="{{ route('video.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $videos->links() }}
                    @else
                       <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

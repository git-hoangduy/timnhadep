@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('campaign.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chiến dịch
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($campaigns->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên chiến dịch</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($campaigns as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('campaign.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('campaign.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $campaigns->links() }}
                    @else
                       <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

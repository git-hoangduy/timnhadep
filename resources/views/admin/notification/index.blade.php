@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    Lọc thông báo
                </div>
                <div class="card-body">
                    <form action="{{ route('notification.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="keyword" placeholder="Nhập nội dung, tên, SĐT, IP" value="{{ request()->keyword ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="{{ route('notification.index') }}" class="btn btn-success">Làm mới</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thông báo
                    @if ($notifications->count())
                        <small class="text-secondary">{{ "Hiển thị " .  $notifications->firstItem() . "-" . $notifications->lastItem() . " của " . $notifications->total() . ' thông báo' }}</small>
                    @endif
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($notifications->count())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nội dung</th>
                                    <th scope="col" class="text-center">Đã xem</th>
                                    <th scope="col">Khách</th>
                                    <th scope="col">SĐT</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $item)
                                    <tr>
                                        <td style="white-space: normal;">{{ $item->message }}</td>
                                        <td class="text-center">{{ (int)($item->is_read ?? 0) === 1 ? '✓' : '' }}</td>
                                        <td>{{ $item->customer_name }}</td>
                                        <td>{{ $item->customer_phone }}</td>
                                        <td>{{ $item->ip }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $notifications->links() }}
                    @else
                        <p class="text-center">Không có kết quả nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        try {
            var maxId = {{ (int) ($notifications->getCollection()->max('id') ?? 0) }};
            if (maxId > 0) {
                localStorage.setItem('notify_last_id', String(maxId));
            }
        } catch (e) {}
    })();
</script>
@endpush

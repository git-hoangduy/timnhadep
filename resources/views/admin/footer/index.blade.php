@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('footer.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    Lọc footer
                </div>
                <div class="card-body">
                    <form action="{{ route('footer.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="keyword" placeholder="Nhập tên bài viết, mô tả, ..." value="{{ request()->keyword ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="{{ route('footer.index') }}" class="btn btn-success">Làm mới</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Footer
                    <small class="text-secondary">{{ "Hiển thị " .  $footers->firstItem() . "-" . $footers->lastItem() . " của " . $footers ->total() . ' footer' }}</small>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($footers->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên footer</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($footers as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">
                                        <div class="form-check d-inline-block form-switch">
                                            <input class="form-check-input status-switch" type="checkbox" {{ $item->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('footer.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('footer.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $footers->links() }}
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

    $('.status-switch').change(function(){
        let _this = $(this);
        let id =  _this.closest('tr').attr('data-id');
        let status = _this.is(':checked') ? 1 : 0;
        let data = [{'id': id, 'status': status }];
        $.ajax({
            url: '{{ route("footer.massUpdate") }}',
            type: 'POST',
            data: JSON.stringify(data),
            beforeSend: function() {
                _this.hide();
                _this.closest('.form-check').addClass('ps-0');
                _this.after('<i class="fa-solid fa-spinner fa-spin"></i>');
            },
            success: function(res){
                if(res && res.success) {
                    console.log(res);
                }
            },
            complete: function() {
                _this.show();
                _this.closest('.form-check').removeClass('ps-0');
                _this.next('i').remove();
            },
        });
    });
</script>
@endpush
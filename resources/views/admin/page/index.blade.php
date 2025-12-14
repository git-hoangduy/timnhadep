@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('page.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Trang tĩnh
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($pages->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Tên trang</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($pages as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>
                                        {{ $item->category->name ?? '' }}
                                        @if(in_array($item->id, [1,2]))
                                            <small class="text-secondary fw-bold">(Trang mặc định)</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">
                                        @if($item->id != 1)
                                            <div class="form-check d-inline-block form-switch">
                                                <input class="form-check-input status-switch" type="checkbox" {{ $item->status == 1 ? 'checked' : '' }}>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('page.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        @if(!in_array($item->id, [1,2]))
                                            <form action="{{ route('page.destroy', $item->id) }}" method="POST" class="d-inline-block">
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
                    {{ $pages->links() }}
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
            url: '{{ route("page.massUpdate") }}',
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
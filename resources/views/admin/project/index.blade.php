@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('project.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Dự án
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')

                    @if ($projects->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Tên dự án</th>
                                <th scope="col">Nổi bật</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($projects as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>
                                        {{ $item->category->name ?? '' }}
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input is_highlight" type="checkbox" value="" id="is_highlight_{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->is_highlight == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_highlight_{{ $item->id }}">
                                              Nổi bật
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($item->id != 1)
                                            <div class="form-check d-inline-block form-switch">
                                                <input class="form-check-input status-switch" type="checkbox" {{ $item->status == 1 ? 'checked' : '' }}>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('project.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('project.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $projects->links() }}
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
            url: '{{ route("project.massUpdate") }}',
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

    $('.is_highlight').change(function() {

        let _this = $(this);
        let status = _this.is(':checked') ? '1' : '0';
        let id = _this.attr('data-id');

        $.ajax({
            url: '{{ route("project.isHighlight") }}',
            type: 'POST',
            data: {
                status: status, 
                id: id
            },
            beforeSend: function() {
                _this.hide();
                _this.closest('.form-check').css('padding-left', 0);
                _this.after('<i class="fa-solid fa-spinner fa-spin"></i>');
            },
            success: function(res){
                if(res && res.success) {
                    console.log(res);
                }
            },
            complete: function() {
                _this.show();
                _this.closest('.form-check').css('padding-left', '1.5em');
                _this.next('i').remove();
            },
        });
    })

</script>
@endpush
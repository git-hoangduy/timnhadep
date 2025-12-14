@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('listing.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    Lọc bài mua bán
                </div>
                <div class="card-body">
                    <form action="{{ route('listing.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="keyword" placeholder="Nhập tên Bài mua bán, mô tả, ..." value="{{ request()->keyword ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <select name="category" class="form-control select2" style="width: 100%">
                                    <option value="">- Tất cả danh mục -</option>
                                    @foreach($categories as $category)
                                        @include('admin.listing-category.includes.option', ['category' => $category, 'selected' => request()->category, 'full' => 1])
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="{{ route('listing.index') }}" class="btn btn-success">Làm mới</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Bài mua bán
                    <small class="text-secondary">{{ "Hiển thị " .  $listings->firstItem() . "-" . $listings->lastItem() . " của " . $listings ->total() . ' Bài mua bán' }}</small>
                </div>
                <div class="card-body">
                    
                    @include('admin.includes.notification')

                    <h6 class="card-title text-secondary">
                        <p class="mb-2">Bài mua bán sẽ được sắp sắp theo thứ tự bài nổi bật và mới nhất.</p>
                        <p class="mb-3">Sử dụng mã <b>[FEATURED-POSTS]</b> đễ nhúng bài biết nỗi bật vào các trang</p>
                    </h6>

                    @if ($listings->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Tên bài mua bán</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col">Nổi bật</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thời gian đăng</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($listings as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>
                                        @if($item->image != '')
                                            <img src="{{ asset($item->image) }}" width="25" height="25">
                                        @else
                                            <img src="{{ asset('uploads/default.png') }}" width="25" height="25">
                                        @endif
                                    </td>
                                    <td>{{ $item->category->name ?? '' }}</td>
                                    <td style="width:30%">{{ $item->name }}</td>
                                    <td class="text-center">
                                        <div class="form-check d-inline-block form-switch">
                                            <input class="form-check-input status-switch" type="checkbox" {{ $item->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input is_highlight" type="checkbox" value="" id="is_highlight_{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->is_highlight == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_highlight_{{ $item->id }}">
                                              Nổi bật
                                            </label>
                                          </div>
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>{{ $item->public_at }}</td>
                                    <td>
                                        <a href="{{ route('post.edit', $item->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <form action="{{ route('post.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $listings->links() }}
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
            url: '{{ route("listing.massUpdate") }}',
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
            url: '{{ route("listing.isHighlight") }}',
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
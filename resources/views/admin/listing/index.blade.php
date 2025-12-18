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
                                <select name="status" class="form-control">
                                    <option value="">- Tất cả trạng thái -</option>
                                    <option value="0" {{ request()->status === '0' ? 'selected' : '' }}>Chờ duyệt</option>
                                    <option value="1" {{ request()->status === '1' ? 'selected' : '' }}>Đã duyệt</option>
                                    <option value="2" {{ request()->status === '2' ? 'selected' : '' }}>Từ chối</option>
                                    <option value="3" {{ request()->status === '3' ? 'selected' : '' }}>Hết hạn</option>
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

                    @if ($listings->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Tên bài mua bán</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Thời gian đăng</th>
                                <th scope="col" class="text-center">Duyệt</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listings as $item)
                            <tr data-id="{{ $item->id }}">
                                <td>
                                    @if($item->avatar_image != '')
                                        <img src="{{ asset($item->avatar_image) }}" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                                    @else
                                        <img src="{{ asset('uploads/default.png') }}" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                                    @endif
                                </td>
                                <td>{{ $item->category->name ?? '' }}</td>
                                <td style="width:25%">
                                    <div class="fw-bold">{{ $item->name }}</div>
                                    <small class="text-muted">{{ $item->type_text }} • {{ $item->formatted_price }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $item->status_badge }}">{{ $item->status_text }}</span>
                                </td>
                                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->public_at ?? $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    @if($item->status == \App\Models\Listing::STATUS_PENDING)
                                    <button type="button" 
                                            class="btn btn-sm btn-success btn-approve" 
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}">
                                        <i class="fas fa-check"></i> Duyệt
                                    </button>
                                    @elseif($item->status == \App\Models\Listing::STATUS_ACTIVE)
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Đã duyệt</span>
                                    @elseif($item->status == \App\Models\Listing::STATUS_REJECTED)
                                    <button type="button" 
                                            class="btn btn-sm btn-warning btn-reapprove" 
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}">
                                        <i class="fas fa-redo"></i> Duyệt lại
                                    </button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('listing.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('listing.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-danger btnDelete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('listing.detail', ['slug' => $item->slug]) }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
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

@push('styles')
<style>
    .btn-approve, .btn-reapprove {
        min-width: 80px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Function to approve listing
    function approveListing(id, callback) {
        $.ajax({
            url: '{{ route("listing.approve") }}',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('tr[data-id="' + id + '"] .btn-approve, tr[data-id="' + id + '"] .btn-reapprove').prop('disabled', true);
                $('tr[data-id="' + id + '"] .btn-approve').html('<i class="fas fa-spinner fa-spin"></i>');
                $('tr[data-id="' + id + '"] .btn-reapprove').html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                if (response.success) {
                    if (callback && typeof callback === 'function') {
                        callback(response);
                    }
                    
                    // Reload page after 1.5 seconds
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Vui lòng thử lại'));
                    $('tr[data-id="' + id + '"] .btn-approve, tr[data-id="' + id + '"] .btn-reapprove').prop('disabled', false);
                    $('tr[data-id="' + id + '"] .btn-approve').html('<i class="fas fa-check"></i> Duyệt');
                    $('tr[data-id="' + id + '"] .btn-reapprove').html('<i class="fas fa-redo"></i> Duyệt lại');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra, vui lòng thử lại');
                $('tr[data-id="' + id + '"] .btn-approve, tr[data-id="' + id + '"] .btn-reapprove').prop('disabled', false);
                $('tr[data-id="' + id + '"] .btn-approve').html('<i class="fas fa-check"></i> Duyệt');
                $('tr[data-id="' + id + '"] .btn-reapprove').html('<i class="fas fa-redo"></i> Duyệt lại');
            }
        });
    }

    // Approve button click
    $('.btn-approve').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        if (confirm('Bạn có chắc chắn muốn duyệt tin đăng: "' + name + '"?')) {
            approveListing(id, function(response) {
                alert('Đã duyệt tin đăng thành công!');
            });
        }
    });

    // Re-approve button click (for rejected listings)
    $('.btn-reapprove').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        if (confirm('Bạn có chắc chắn muốn duyệt lại tin đăng: "' + name + '"?')) {
            approveListing(id, function(response) {
                alert('Đã duyệt lại tin đăng thành công!');
            });
        }
    });

    // Status switch change
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
});
</script>
@endpush
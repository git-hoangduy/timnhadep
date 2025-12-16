@extends('website.master')

@section('content')
<div class="container py-4">
    <!-- Header trang -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-newspaper me-2"></i>Tin đã đăng</h2>
            <p class="text-muted mb-0">Quản lý tất cả tin đăng bất động sản của bạn</p>
        </div>
        <div>
            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-user-circle me-1"></i> Tài khoản
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">
                <i class="fas fa-plus me-1"></i> Đăng tin mới
            </button>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Tổng tin</h5>
                    <h2 class="text-primary">{{ $listings->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Đã duyệt</h5>
                    <h2 class="text-success">{{ $approvedCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Chờ duyệt</h5>
                    <h2 class="text-warning">{{ $pendingCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Đã xóa</h5>
                    <h2 class="text-danger">{{ $deletedCount ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng danh sách tin đăng -->
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($listings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Thông tin tin đăng</th>
                                <th width="100">Hình thức</th>
                                <th width="120">Giá / Diện tích</th>
                                <th width="120">Trạng thái</th>
                                <th width="140">Ngày đăng</th>
                                <th width="150" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listings as $listing)
                                <tr id="listing-row-{{ $listing->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($listing->image)
                                                <img src="{{ asset($listing->image) }}" 
                                                     alt="{{ $listing->name }}" 
                                                     class="rounded me-3"
                                                     style="width: 80px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                                     style="width: 80px; height: 60px;">
                                                    <i class="fas fa-home text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('listing.detail', $listing->slug) }}" 
                                                       target="_blank" 
                                                       class="text-decoration-none text-dark">
                                                        {{ Str::limit($listing->name, 60) }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-map-marker-alt me-1"></i> 
                                                    {{ Str::limit($listing->location, 40) }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="fas fa-folder me-1"></i> 
                                                    {{ $listing->category->name ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($listing->type == 'sale')
                                            <span class="badge bg-danger">Cần bán</span>
                                        @elseif($listing->type == 'rent')
                                            <span class="badge bg-warning">Cho thuê</span>
                                        @elseif($listing->type == 'buy')
                                            <span class="badge bg-success">Cần mua</span>
                                        @else
                                            <span class="badge bg-info">Cần thuê</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-primary">{{ $listing->price }}</div>
                                        <small class="text-muted">{{ $listing->area }} m²</small>
                                    </td>
                                    <td>
                                        @if($listing->status == 0)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i> Chờ duyệt
                                            </span>
                                        @elseif($listing->status == 1)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i> Đã duyệt
                                            </span>
                                        @elseif($listing->status == 2)
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i> Từ chối
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-ban me-1"></i> Hết hạn
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $listing->created_at->format('d/m/Y') }}<br>
                                        <small class="text-muted">{{ $listing->created_at->format('H:i') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('listing.detail', $listing->slug) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               target="_blank"
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-warning edit-listing"
                                                    data-id="{{ $listing->id }}"
                                                    title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-listing" 
                                                    data-id="{{ $listing->id }}"
                                                    data-title="{{ $listing->name }}"
                                                    title="Xóa tin">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Hiển thị {{ $listings->firstItem() }} - {{ $listings->lastItem() }} 
                        của {{ $listings->total() }} tin
                    </div>
                    <div>
                        {{ $listings->links() }}
                    </div>
                </div>

            @else
                <!-- Trạng thái không có tin đăng -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-newspaper fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Bạn chưa có tin đăng nào</h4>
                    <p class="text-muted mb-4">Hãy bắt đầu đăng tin bất động sản đầu tiên của bạn để tiếp cận hàng nghìn khách hàng tiềm năng!</p>
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#postModal">
                        <i class="fas fa-plus me-2"></i>Đăng tin mới ngay
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Hướng dẫn nhanh -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Lưu ý quan trọng</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <ul class="mb-0">
                        <li>Tin ở trạng thái <span class="badge bg-warning">Chờ duyệt</span> sẽ được kiểm duyệt trong 24h</li>
                        <li>Tin <span class="badge bg-success">Đã duyệt</span> hiển thị công khai trên website</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="mb-0">
                        <li>Tin tự động hết hạn sau 30 ngày</li>
                        <li>Bạn có thể chỉnh sửa tin đăng bất kỳ lúc nào</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tin đăng:</p>
                <h6 id="delete-listing-title" class="text-danger mb-3"></h6>
                <p class="text-muted"><small>Hành động này sẽ xóa vĩnh viễn tin đăng và tất cả hình ảnh liên quan. Không thể hoàn tác!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Xóa vĩnh viễn</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let listingToDelete = null;
        
        // Mở modal xác nhận xóa
        $('.delete-listing').on('click', function() {
            const listingId = $(this).data('id');
            const listingTitle = $(this).data('title');
            
            listingToDelete = listingId;
            $('#delete-listing-title').text(listingTitle);
            $('#deleteModal').modal('show');
        });
        
        // Xác nhận xóa tin đăng
        $('#confirm-delete').on('click', function() {
            if (!listingToDelete) return;
            
            // Hiển thị loading
            const deleteBtn = $(this);
            const originalText = deleteBtn.html();
            deleteBtn.html('<i class="fas fa-spinner fa-spin me-1"></i> Đang xóa...');
            deleteBtn.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("user.listings.destroy", "") }}/' + listingToDelete,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Ẩn modal
                        $('#deleteModal').modal('hide');
                        
                        // Xóa dòng khỏi bảng
                        $('#listing-row-' + listingToDelete).fadeOut(300, function() {
                            $(this).remove();
                            
                            // Hiển thị thông báo thành công
                            showAlert('success', response.message);
                            
                            // Reload nếu không còn tin nào
                            setTimeout(() => {
                                if ($('tbody tr').length === 0) {
                                    location.reload();
                                }
                            }, 1000);
                        });
                    } else {
                        showAlert('danger', response.message || 'Có lỗi xảy ra');
                    }
                },
                error: function(xhr) {
                    showAlert('danger', 'Lỗi kết nối! Vui lòng thử lại.');
                },
                complete: function() {
                    deleteBtn.html(originalText);
                    deleteBtn.prop('disabled', false);
                    listingToDelete = null;
                }
            });
        });
        
        // Chức năng chỉnh sửa (tạm thời)
        $('.edit-listing').on('click', function() {
            alert('Chức năng chỉnh sửa đang được phát triển!');
        });
        
        // Hàm hiển thị thông báo
        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${icon} me-2"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            $('.card-body').prepend(alertHtml);
            
            // Tự động ẩn sau 5 giây
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        }
        
        // Kiểm tra đăng nhập khi click đăng tin mới
        $('.btn-primary[data-bs-target="#postModal"]').on('click', function() {
            @if(!Auth::guard('customer')->check())
                alert('Vui lòng đăng nhập để đăng tin!');
                return false;
            @endif
        });
    });
</script>
@endpush
@extends('website.master')

@section('content')
<div class="user-page-wrapper">
    <div class="user-container">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-left">
                    <h1>Tin đã đăng</h1>
                </div>
                <div class="page-header-actions">
                    <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-user-circle me-1"></i> Tài khoản
                    </a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">
                        <i class="fas fa-plus me-1"></i> Đăng tin mới
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">
                    <i class="fas fa-layer-group"></i>
                    Tổng tin
                </div>
                <div class="stat-value text-primary">{{ $listings->total() }}</div>
            </div>
            
            <div class="stat-card border-success">
                <div class="stat-label">
                    <i class="fas fa-check-circle"></i>
                    Đã duyệt
                </div>
                <div class="stat-value text-success">{{ $approvedCount }}</div>
            </div>
            
            <div class="stat-card border-warning">
                <div class="stat-label">
                    <i class="fas fa-clock"></i>
                    Chờ duyệt
                </div>
                <div class="stat-value text-warning">{{ $pendingCount }}</div>
            </div>
            
            <!-- <div class="stat-card border-danger">
                <div class="stat-label">
                    <i class="fas fa-trash"></i>
                    Đã xóa
                </div>
                <div class="stat-value text-danger">{{ $deletedCount ?? 0 }}</div>
            </div> -->
        </div>

        <!-- Main Content -->
        <div class="content-card">
            <div class="content-card-header">
                <h5 class="mb-0"><i class="fas fa-list-check"></i> Danh sách tin đăng</h5>
            </div>
            <div class="content-card-body">
                
                @if(session('success'))
                    <div class="alert alert-success alert-modern">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-modern">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($listings->count() > 0)
                    <div class="table-container">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Thông tin tin đăng</th>
                                    <th>Hình thức</th>
                                    <th>Giá / Diện tích</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng</th>
                                    <th class="text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listings as $listing)
                                    <tr id="listing-row-{{ $listing->id }}">
                                        <td data-label="Thông tin">
                                            <div class="listing-item">
                                                <div class="listing-image">
                                                    @if($listing->image)
                                                        <img src="{{ asset($listing->image) }}" alt="{{ $listing->name }}">
                                                    @else
                                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                                            <i class="fas fa-home text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="listing-info__">
                                                    <h6>
                                                        <a href="{{ route('listing.detail', $listing->slug) }}" 
                                                           target="_blank" 
                                                           class="text-decoration-none text-dark hover-primary">
                                                            {{ Str::limit($listing->name, 20) }}
                                                        </a>
                                                    </h6>
                                                    <div class="meta">
                                                        <span><i class="fas fa-map-marker-alt"></i> {{ Str::limit($listing->location, 30) }}</span>
                                                        <span class="ms-3"><i class="fas fa-folder"></i> {{ $listing->category->name ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td data-label="Hình thức">
                                            @if($listing->type == 'sale')
                                                <span class="badge-modern" style="background: #fee2e2; color: #dc2626; border-color: #fecaca;">
                                                    Cần bán
                                                </span>
                                            @elseif($listing->type == 'rent')
                                                <span class="badge-modern" style="background: #fef3c7; color: #d97706; border-color: #fde68a;">
                                                    Cho thuê
                                                </span>
                                            @elseif($listing->type == 'buy')
                                                <span class="badge-modern" style="background: #d1fae5; color: #059669; border-color: #a7f3d0;">
                                                    Cần mua
                                                </span>
                                            @else
                                                <span class="badge-modern" style="background: #e0e7ff; color: #4f46e5; border-color: #c7d2fe;">
                                                    Cần thuê
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td data-label="Giá / Diện tích">
                                            <div class="fw-bold text-dark">{{ $listing->price }}</div>
                                            <small class="text-muted">{{ $listing->area }} m²</small>
                                        </td>
                                        
                                        <td data-label="Trạng thái">
                                            @if($listing->status == 0)
                                                <span class="badge-status" style="color: #f59e0b;">
                                                    <i class="fas fa-clock"></i> Chờ duyệt
                                                </span>
                                            @elseif($listing->status == 1)
                                                <span class="badge-status" style="color: #10b981;">
                                                    <i class="fas fa-check"></i> Đã duyệt
                                                </span>
                                            @elseif($listing->status == 2)
                                                <span class="badge-status" style="color: #ef4444;">
                                                    <i class="fas fa-times"></i> Từ chối
                                                </span>
                                            @else
                                                <span class="badge-status" style="color: #64748b;">
                                                    <i class="fas fa-ban"></i> Hết hạn
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td data-label="Ngày đăng">
                                            {{ $listing->created_at->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">{{ $listing->created_at->format('H:i') }}</small>
                                        </td>
                                        
                                        <td data-label="Thao tác" class="text-end">
                                            <div class="action-buttons">
                                                <a href="{{ route('listing.detail', $listing->slug) }}" 
                                                   class="btn-action view" 
                                                   target="_blank"
                                                   title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <!-- <button class="btn-action edit edit-listing"
                                                        data-id="{{ $listing->id }}"
                                                        title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button> -->
                                                <button class="btn-action delete delete-listing" 
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

                    <!-- Pagination -->
                    <div class="pagination-modern">
                        <div class="pagination-info">
                            <i class="fas fa-info-circle"></i>
                            Hiển thị {{ $listings->firstItem() }} - {{ $listings->lastItem() }} 
                            của {{ $listings->total() }} tin
                        </div>
                        <div class="pagination-links">
                            {{ $listings->links() }}
                        </div>
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h4>Bạn chưa có tin đăng nào</h4>
                        <p>Hãy bắt đầu đăng tin bất động sản đầu tiên của bạn để tiếp cận hàng nghìn khách hàng tiềm năng!</p>
                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#postModal">
                            <i class="fas fa-plus me-2"></i>Đăng tin mới ngay
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tips Card -->
        <div class="tips-card">
            <div class="tips-card-header">
                <i class="fas fa-info-circle" style="color: #f59e0b;"></i>
                <h6>Lưu ý quan trọng</h6>
            </div>
            <div class="tips-card-body">
                <ul>
                    <li>Tin ở trạng thái <strong>Chờ duyệt</strong> sẽ được kiểm duyệt trong 48h</li>
                    <li>Tin <strong>Đã duyệt</strong> hiển thị công khai trên website</li>
                    <!-- <li>Tin tự động hết hạn sau 30 ngày kể từ ngày đăng</li>
                    <li>Bạn có thể chỉnh sửa tin đăng bất kỳ lúc nào</li> -->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade modal-modern" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-circle bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Xác nhận xóa tin đăng</h5>
                            <p class="text-muted mb-0">Hành động này không thể hoàn tác</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tin đăng:</p>
                <div class="alert alert-light border mt-3">
                    <i class="fas fa-file-alt me-2 text-primary"></i>
                    <strong id="delete-listing-title"></strong>
                </div>
                <p class="text-muted small mt-3">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Tất cả hình ảnh và thông tin liên quan sẽ bị xóa vĩnh viễn.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">
                    <i class="fas fa-trash me-1"></i> Xóa vĩnh viễn
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.hover-primary:hover {
    color: var(--primary-color) !important;
}
</style>
@endpush

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
                        $('#deleteModal').modal('hide');
                        
                        // Animation xóa
                        $('#listing-row-' + listingToDelete).fadeOut(400, function() {
                            $(this).remove();
                            
                            // Show success message
                            showToast('success', response.message);
                            
                            // Reload if no listings left
                            if ($('.table-modern tbody tr').length === 0) {
                                setTimeout(() => location.reload(), 1000);
                            }
                        });
                    } else {
                        showToast('error', response.message || 'Có lỗi xảy ra');
                    }
                },
                error: function(xhr) {
                    showToast('error', 'Lỗi kết nối! Vui lòng thử lại.');
                },
                complete: function() {
                    deleteBtn.html(originalText);
                    deleteBtn.prop('disabled', false);
                    listingToDelete = null;
                }
            });
        });
        
        // Chức năng chỉnh sửa
        $('.edit-listing').on('click', function() {
            showToast('info', 'Chức năng chỉnh sửa đang được phát triển!');
        });
        
        // Hàm hiển thị toast
        function showToast(type, message) {
            const toastId = 'toast-' + Date.now();
            const icon = type === 'success' ? 'fa-check-circle' : 
                         type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
            const bgColor = type === 'success' ? 'bg-success' : 
                           type === 'error' ? 'bg-danger' : 'bg-info';
            
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgColor} border-0 position-fixed" 
                     style="bottom: 20px; right: 20px; z-index: 9999;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas ${icon} me-2"></i> ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            $('body').append(toastHtml);
            const toast = new bootstrap.Toast(document.getElementById(toastId));
            toast.show();
            
            // Auto remove
            setTimeout(() => {
                $(`#${toastId}`).remove();
            }, 5000);
        }
        
        // Kiểm tra đăng nhập
        $('.btn-primary[data-bs-target="#postModal"]').on('click', function() {
            @if(!Auth::guard('customer')->check())
                showToast('error', 'Vui lòng đăng nhập để đăng tin!');
                return false;
            @endif
        });
    });
</script>
@endpush
@extends('website.master')

@section('content')
<div class="container py-4">
    <!-- Header trang -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-user-circle me-2"></i>Thông tin cá nhân</h2>
            <p class="text-muted mb-0">Quản lý thông tin tài khoản của bạn</p>
        </div>
        <div>
            <a href="{{ route('user.my-listings') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-newspaper me-1"></i> Tin đã đăng
            </a>
            <a href="{{ route('user.password') }}" class="btn btn-outline-primary">
                <i class="fas fa-key me-1"></i> Đổi mật khẩu
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Cột trái: Thông tin cá nhân -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Cập nhật thông tin</h5>
                </div>
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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Vui lòng kiểm tra các lỗi sau:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="profileForm" method="POST" action="{{ route('user.profile') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" 
                                       value="{{ $user->email }}" readonly disabled>
                                <small class="text-muted">Email không thể thay đổi</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', $user->phone) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" 
                                       value="{{ old('address', $user->address) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" 
                                             alt="Avatar" 
                                             class="img-thumbnail" 
                                             id="avatarPreview"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="border rounded d-flex align-items-center justify-content-center" 
                                             id="avatarPreview"
                                             style="width: 150px; height: 150px; background-color: #f8f9fa;">
                                            <i class="fas fa-user fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <input type="file" class="form-control" id="avatar" name="avatar" 
                                           accept="image/*" onchange="previewAvatar(event)">
                                    <small class="text-muted">Chọn ảnh đại diện mới (JPG, PNG, max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="reset" class="btn btn-secondary">Đặt lại</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%"><strong>Ngày tham gia:</strong></td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Loại tài khoản:</strong></td>
                                    <td>
                                        @if($user->provider)
                                            <span class="badge bg-info">Đăng nhập bằng {{ ucfirst($user->provider) }}</span>
                                        @else
                                            <span class="badge bg-success">Tài khoản thường</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Trạng thái:</strong></td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%"><strong>Tổng tin đã đăng:</strong></td>
                                    <td>
                                        <a href="{{ route('user.my-listings') }}" class="text-decoration-none">
                                            {{ $totalListings }} tin
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tin đã duyệt:</strong></td>
                                    <td>{{ $approvedListings }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tin chờ duyệt:</strong></td>
                                    <td>{{ $pendingListings }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột phải: Avatar và quick actions -->
        <div class="col-md-4">
            <!-- Avatar lớn -->
            <div class="card text-center mb-4">
                <div class="card-body">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" 
                             alt="Avatar" 
                             class="rounded-circle mb-3"
                             style="width: 180px; height: 180px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 180px; height: 180px;">
                            <i class="fas fa-user fa-4x text-muted"></i>
                        </div>
                    @endif
                    
                    <h4 class="mb-1">{{ $user->name ?: 'Chưa có tên' }}</h4>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    
                    @if($user->phone)
                        <p class="mb-3">
                            <i class="fas fa-phone me-2"></i>{{ $user->phone }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Quick actions -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Thao tác nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('user.my-listings') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-newspaper me-2"></i> Tin đã đăng</span>
                            <span class="badge bg-primary rounded-pill">{{ $totalListings }}</span>
                        </a>
                        <a href="{{ route('user.password') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-key me-2"></i> Đổi mật khẩu
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2 text-danger"></i> Đăng xuất
                        </a>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <!-- Thông báo bảo mật -->
            <div class="card mt-4 border-warning">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Bảo mật tài khoản</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0 small">
                        <li>Không chia sẻ mật khẩu với người khác</li>
                        <li>Thường xuyên đổi mật khẩu</li>
                        <li>Kiểm tra email định kỳ</li>
                        <li>Liên hệ admin nếu có vấn đề</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewAvatar(event) {
    const input = event.target;
    const preview = document.getElementById('avatarPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Nếu là div, chuyển thành img
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.objectFit = 'cover';
                img.id = 'avatarPreview';
                
                preview.parentNode.replaceChild(img, preview);
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            
            // Reset validation
            nameInput.classList.remove('is-invalid');
            phoneInput.classList.remove('is-invalid');
            
            let isValid = true;
            
            // Validate tên
            if (!nameInput.value.trim()) {
                nameInput.classList.add('is-invalid');
                showInlineError('name', 'Vui lòng nhập họ tên');
                isValid = false;
            }
            
            // Validate số điện thoại
            const phoneRegex = /^(0|\+84)[3|5|7|8|9][0-9]{8}$/;
            if (!phoneInput.value.trim()) {
                phoneInput.classList.add('is-invalid');
                showInlineError('phone', 'Vui lòng nhập số điện thoại');
                isValid = false;
            } else if (!phoneRegex.test(phoneInput.value.replace(/\s/g, ''))) {
                phoneInput.classList.add('is-invalid');
                showInlineError('phone', 'Số điện thoại không hợp lệ');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    function showInlineError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;
        
        // Xóa error cũ
        const oldError = field.parentNode.querySelector('.invalid-feedback');
        if (oldError) oldError.remove();
        
        field.parentNode.appendChild(errorDiv);
    }
    
    // Xử lý file upload size
    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (file && file.size > maxSize) {
                alert('Kích thước ảnh không được vượt quá 2MB');
                e.target.value = '';
                return false;
            }
        });
    }
});
</script>

@endpush
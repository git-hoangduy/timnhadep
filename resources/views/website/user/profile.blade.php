@extends('website.master')

@section('content')
<div class="user-page-wrapper">
    <div class="user-container">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-left">
                    <h1>Thông tin cá nhân</h1>
                </div>
                <div class="page-header-actions">
                    <a href="{{ route('user.my-listings') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-newspaper me-1"></i> Tin đã đăng
                    </a>
                    <a href="{{ route('user.password') }}" class="btn btn-outline-primary">
                        <i class="fas fa-key me-1"></i> Đổi mật khẩu
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0"><i class="fas fa-edit"></i> Cập nhật thông tin</h5>
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

                        @if($errors->any())
                            <div class="alert alert-danger alert-modern">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <strong class="d-block mb-2">Vui lòng kiểm tra các lỗi sau:</strong>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form id="profileForm" method="POST" action="{{ route('user.profile') }}">
                            @csrf
                            
                            <div class="form-section">
                             
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                               value="{{ old('name', $user->name) }}" required
                                               placeholder="Nguyễn Văn A">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg bg-light" id="email" 
                                               value="{{ $user->email }}" readonly>
                                        <small class="text-muted mt-1 d-block">
                                            <i class="fas fa-info-circle me-1"></i> Email không thể thay đổi
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control form-control-lg" id="phone" name="phone" 
                                               value="{{ old('phone', $user->phone) }}" required
                                               placeholder="0912 345 678">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <input type="text" class="form-control form-control-lg" id="address" name="address" 
                                               value="{{ old('address', $user->address) }}"
                                               placeholder="Số nhà, đường, phường, quận...">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pt-4 mt-4 border-top">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-1"></i> Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="content-card mt-4">
                    <div class="content-card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin tài khoản</h5>
                    </div>
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                 
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <span class="text-muted">Ngày tham gia:</span>
                                            <span class="fw-semibold">{{ $user->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Logout -->
                        <div class="text-center pt-4 border-top">
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-lg px-4">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Sidebar -->
            <div class="col-lg-4">
                <!-- Account Summary -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5 class="mb-0"><i class="fas fa-user-check"></i> Tài khoản</h5>
                    </div>
                    <div class="content-card-body text-center">
                        <div class="mb-4">
                            <div class="avatar-circle mx-auto mb-3">
                                @if($user->avatar)
                                    <img src="{{ asset($user->avatar) }}" alt="Avatar" class="img-fluid rounded-circle">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="mb-2">{{ $user->name ?: 'Chưa có tên' }}</h5>
                            <p class="text-muted mb-3">{{ $user->email }}</p>
                            @if($user->phone)
                                <p class="mb-0">
                                    <i class="fas fa-phone me-2"></i>{{ $user->phone }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="stats-grid-small">
                            <div class="stat-small">
                                <div class="stat-value text-primary">{{ $totalListings }}</div>
                                <div class="stat-label">Tin đăng</div>
                            </div>
                            <div class="stat-small">
                                <div class="stat-value text-success">{{ $approvedListings }}</div>
                                <div class="stat-label">Đã duyệt</div>
                            </div>
                            <div class="stat-small">
                                <div class="stat-value text-warning">{{ $pendingListings }}</div>
                                <div class="stat-label">Chờ duyệt</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h5><i class="fas fa-shield-alt"></i> Bảo mật</h5>
                    </div>
                    <div class="content-card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3">
                                <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                                <span>Đổi mật khẩu thường xuyên</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                                <span>Không chia sẻ thông tin đăng nhập</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                                <span>Liên hệ admin nếu có vấn đề</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #f1f5f9;
}

.avatar-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 3rem;
}

.stats-grid-small {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.stat-small {
    text-align: center;
    padding: 15px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-small .stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-small .stat-label {
    font-size: 0.85rem;
    color: #64748b;
    white-space: nowrap;
}
</style>
@endpush

@push('scripts')
<script>
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
                showError(nameInput, 'Vui lòng nhập họ tên');
                isValid = false;
            }
            
            // Validate số điện thoại
            const phoneRegex = /^(0|\+84)[3|5|7|8|9][0-9]{8}$/;
            if (!phoneInput.value.trim()) {
                phoneInput.classList.add('is-invalid');
                showError(phoneInput, 'Vui lòng nhập số điện thoại');
                isValid = false;
            } else if (!phoneRegex.test(phoneInput.value.replace(/\s/g, ''))) {
                phoneInput.classList.add('is-invalid');
                showError(phoneInput, 'Số điện thoại không hợp lệ (VD: 0912345678)');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                showToast('error', 'Vui lòng kiểm tra lại thông tin');
            }
        });
    }
    
    function showError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block mt-2';
        errorDiv.textContent = message;
        
        // Xóa error cũ
        const oldError = input.parentNode.querySelector('.invalid-feedback');
        if (oldError) oldError.remove();
        
        input.parentNode.appendChild(errorDiv);
    }
    
    function showToast(type, message) {
        const toastId = 'toast-' + Date.now();
        const icon = type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        const bgColor = type === 'error' ? 'bg-danger' : 'bg-info';
        
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
        
        setTimeout(() => $(`#${toastId}`).remove(), 5000);
    }
});
</script>
@endpush
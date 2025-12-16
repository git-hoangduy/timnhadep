@extends('website.master')

@section('content')
<div class="container py-4">
    <!-- Header trang -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-key me-2"></i>Đổi mật khẩu</h2>
            <p class="text-muted mb-0">Cập nhật mật khẩu mới cho tài khoản của bạn</p>
        </div>
        <div>
            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-user-circle me-1"></i> Thông tin cá nhân
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Cập nhật mật khẩu</h5>
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

                    <form id="passwordForm" method="POST" action="{{ route('user.password') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.profile') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hướng dẫn bảo mật -->
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Mẹo bảo mật mật khẩu</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Sử dụng ít nhất 8 ký tự</li>
                        <li>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                        <li>Không sử dụng thông tin cá nhân làm mật khẩu</li>
                        <li>Thay đổi mật khẩu định kỳ 3-6 tháng/lần</li>
                        <li>Không sử dụng lại mật khẩu cũ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle hiển thị mật khẩu
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // Form validation
    const form = document.getElementById('passwordForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const currentPassword = document.getElementById('current_password');
            const newPassword = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            
            // Reset validation
            [currentPassword, newPassword, confirmPassword].forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            let isValid = true;
            
            // Validate mật khẩu hiện tại
            if (!currentPassword.value.trim()) {
                currentPassword.classList.add('is-invalid');
                showError(currentPassword, 'Vui lòng nhập mật khẩu hiện tại');
                isValid = false;
            }
            
            // Validate mật khẩu mới
            if (!newPassword.value.trim()) {
                newPassword.classList.add('is-invalid');
                showError(newPassword, 'Vui lòng nhập mật khẩu mới');
                isValid = false;
            } else if (newPassword.value.length < 6) {
                newPassword.classList.add('is-invalid');
                showError(newPassword, 'Mật khẩu phải có ít nhất 6 ký tự');
                isValid = false;
            }
            
            // Validate xác nhận mật khẩu
            if (!confirmPassword.value.trim()) {
                confirmPassword.classList.add('is-invalid');
                showError(confirmPassword, 'Vui lòng xác nhận mật khẩu');
                isValid = false;
            } else if (newPassword.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                showError(confirmPassword, 'Mật khẩu xác nhận không khớp');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    function showError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;
        
        // Xóa error cũ
        const oldError = input.parentNode.querySelector('.invalid-feedback');
        if (oldError) oldError.remove();
        
        input.parentNode.appendChild(errorDiv);
    }
});
</script>
@endpush
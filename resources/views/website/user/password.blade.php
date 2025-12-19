@extends('website.master')

@section('content')
<div class="user-page-wrapper">
    <div class="user-container">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-left">
                    <h1>Đổi mật khẩu</h1>
                </div>
                <div class="page-header-actions">
                    <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0"><i class="fas fa-lock"></i> Cập nhật mật khẩu</h5>
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

                        <form id="passwordForm" method="POST" action="{{ route('user.password') }}">
                            @csrf
                            
                            <div class="form-section">
                                <div class="mb-4">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" 
                                               id="current_password" name="current_password" required
                                               placeholder="Nhập mật khẩu hiện tại">
                                        <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                data-target="current_password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">Mật khẩu mới</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" 
                                               id="password" name="password" required
                                               placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)">
                                        <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-info-circle me-1"></i> Mật khẩu phải có ít nhất 6 ký tự
                                    </small>
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" 
                                               id="password_confirmation" name="password_confirmation" required
                                               placeholder="Nhập lại mật khẩu mới">
                                        <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                data-target="password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pt-4 border-top">
                                <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-1"></i> Đổi mật khẩu
                                </button>
                            </div>
                        </form>
                    </div>
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
                showToast('error', 'Vui lòng kiểm tra lại thông tin');
            }
        });
    }
    
    function showError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block mt-2';
        errorDiv.textContent = message;
        
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
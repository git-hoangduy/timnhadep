@extends('website.master')

@section('content')

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Liên hệ
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title center mb-5">Liên hệ với chúng tôi</h2>
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
        </div>
        
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="contact-info-card">
                    <div class="info-item mb-4">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5>Địa chỉ</h5>
                            <p>{{ setting('contact.address', 'Số 123, Đường ABC, Quận XYZ, TP. Hồ Chí Minh') }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item mb-4">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5>Điện thoại</h5>
                            <p>{{ setting('contact.phone', '0901 234 567') }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item mb-4">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h5>Email</h5>
                            <p>{{ setting('contact.email', 'contact@nhadep.com') }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <h5>Giờ làm việc</h5>
                            <p>{{ setting('contact.working_hours', 'Thứ 2 - Thứ 7: 8:00 - 17:30<br>Chủ nhật: 8:00 - 12:00') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-form-card">
                    <h3 class="mb-4">Gửi yêu cầu liên hệ</h3>
                    <p class="text-muted mb-4">Vui lòng điền thông tin bên dưới, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
                    
                    <form action="{{ route('contact') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">Chủ đề</label>
                                <select class="form-select @error('subject') is-invalid @enderror" 
                                        id="subject" 
                                        name="subject">
                                    <option value="">-- Chọn chủ đề --</option>
                                    <option value="consult" {{ old('subject') == 'consult' ? 'selected' : '' }}>Tư vấn mua bán</option>
                                    <option value="post" {{ old('subject') == 'post' ? 'selected' : '' }}>Đăng tin bất động sản</option>
                                    <option value="collaborate" {{ old('subject') == 'collaborate' ? 'selected' : '' }}>Hợp tác</option>
                                    <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Góp ý</option>
                                    <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" 
                                          name="message" 
                                          rows="5" 
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Gửi liên hệ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-container">
                    <h3 class="mb-4">Vị trí của chúng tôi</h3>
                    <div class="map-placeholder">
                        <div class="text-center py-5">
                            <i class="fas fa-map-marked-alt fa-3x mb-3" style="color: var(--primary-color);"></i>
                            <h5>Bản đồ vị trí</h5>
                            <p class="text-muted">{{ setting('contact.address', 'Số 123, Đường ABC, Quận XYZ, TP. Hồ Chí Minh') }}</p>
                            <small class="text-muted">(Bản đồ sẽ được tích hợp tại đây)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Contact Section Styles */
.contact-section {
    padding: 80px 0;
    background-color: var(--light-gray);
}

.contact-info-card {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
    height: 100%;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    transition: var(--transition);
}

.info-item:hover {
    transform: translateX(5px);
}

.info-icon {
    width: 50px;
    height: 50px;
    background-color: rgba(235, 93, 30, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 1.2rem;
    flex-shrink: 0;
}

.info-content h5 {
    font-size: 1.1rem;
    margin-bottom: 8px;
    color: var(--dark-color);
}

.info-content p {
    color: var(--gray-color);
    margin-bottom: 0;
    line-height: 1.6;
}

.contact-form-card {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 40px;
    box-shadow: var(--shadow);
}

.contact-form-card h3 {
    color: var(--dark-color);
    font-weight: 700;
}

.contact-form-card .form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 8px;
}

.contact-form-card .form-control,
.contact-form-card .form-select {
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: var(--transition);
}

.contact-form-card .form-control:focus,
.contact-form-card .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(235, 93, 30, 0.25);
}

.contact-form-card textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.map-container {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
}

.map-placeholder {
    background-color: var(--light-gray);
    border-radius: 8px;
    border: 2px dashed #ddd;
    transition: var(--transition);
}

.map-placeholder:hover {
    border-color: var(--primary-color);
}

.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
}

.alert-success {
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
    border-left: 4px solid #198754;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border-left: 4px solid #dc3545;
}

@media (max-width: 768px) {
    .contact-section {
        padding: 60px 0;
    }
    
    .contact-info-card,
    .contact-form-card {
        padding: 25px;
    }
    
    .info-item {
        gap: 15px;
    }
    
    .info-icon {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }
    
    .info-content h5 {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .contact-info-card,
    .contact-form-card {
        padding: 20px;
    }
    
    .map-container {
        padding: 20px;
    }
    
    .info-item {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .info-icon {
        margin: 0 auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Form validation and enhancement
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const phoneInput = document.getElementById('phone');
    
    // Format phone number input
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = value.match(/(\d{0,4})(\d{0,3})(\d{0,3})/);
            e.target.value = !value[2] ? value[1] : value[1] + ' ' + value[2] + (value[3] ? ' ' + value[3] : '');
        }
    });
    
    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
        submitBtn.disabled = true;
        
        // Re-enable button after 5 seconds in case of error
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });
});
</script>
@endpush
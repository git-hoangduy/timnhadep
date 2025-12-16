<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Nhà Đẹp - Kênh bất động sản số 1 Việt Nam</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Chỉ sử dụng Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
</head>
<body>
    

    @include('website.partials.header')
    @yield('content')

    <!-- Modals -->
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Đăng nhập tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email hoặc số điện thoại</label>
                            <input type="text" class="form-control" id="loginEmail" placeholder="Nhập email hoặc số điện thoại" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="loginPassword" placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                            <a href="#" class="float-end">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Chưa có tài khoản? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Đăng ký ngay</a></p>
                    </div>
                    <!-- <div class="text-center mt-3">
                        <p>Hoặc đăng nhập bằng</p>
                        <button class="btn btn-outline-primary me-2"><i class="fab fa-facebook-f"></i> Facebook</button>
                        <button class="btn btn-outline-danger"><i class="fab fa-google"></i> Google</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Đăng ký tài khoản mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="mb-3">
                            <label for="registerName" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="registerName" placeholder="Nhập họ và tên đệm" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" placeholder="Nhập email" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPhone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="registerPhone" placeholder="Nhập số điện thoại" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="registerPassword" placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" required>
                            <label class="form-check-label" for="acceptTerms">Tôi đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng ký tài khoản</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Đã có tài khoản? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Listing Modal -->
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Đăng tin mua bán mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(Auth::guard('customer')->check())
                        <form id="postForm" enctype="multipart/form-data">
                            <input type="hidden" name="customer_id" value="{{ Auth::guard('customer')->id() }}">
                            
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Tiêu đề tin đăng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="postTitle" name="title" placeholder="Ví dụ: Cần bán căn hộ chung cư 70m² tại Sunshine City" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="propertyType" class="form-label">Loại bất động sản <span class="text-danger">*</span></label>
                                    <select class="form-select" id="propertyType" name="category_id" required>
                                        <option value="">Chọn loại bất động sản</option>
                                        @foreach($listingCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="transactionType" class="form-label">Hình thức <span class="text-danger">*</span></label>
                                    <select class="form-select" id="transactionType" name="type" required>
                                        <option value="">Chọn hình thức</option>
                                        <option value="sale">Cần bán</option>
                                        <option value="rent">Cho thuê</option>
                                        <option value="buy">Cần mua</option>
                                        <option value="rental">Cần thuê</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Ví dụ: 2 tỷ, 15 triệu/tháng" required>
                                    <small class="form-text text-muted">Nhập giá bằng chữ (ví dụ: 2 tỷ, 15 triệu/tháng)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="area" class="form-label">Diện tích (m²) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="area" name="area" placeholder="Ví dụ: 70, 80-100" required>
                                    <small class="form-text text-muted">Nhập diện tích bằng số (ví dụ: 70 hoặc 80-100)</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="location" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="Nhập địa chỉ chi tiết" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Mô tả chi tiết về bất động sản: số phòng, hướng nhà, tiện ích, nội thất..." required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="images" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                                <div class="form-text">Tối đa 10 hình ảnh, dung lượng mỗi hình dưới 5MB. Ảnh đầu tiên sẽ là ảnh đại diện.</div>
                                <div id="imagePreview" class="mt-2 row"></div>
                            </div>
                            
                            <input type="hidden" name="customer_name" value="{{ Auth::guard('customer')->user()->name }}">
                            <input type="hidden" name="customer_phone" value="{{ Auth::guard('customer')->user()->phone }}">
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Đăng tin ngay</button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-lock fa-4x text-warning"></i>
                            </div>
                            <h4>Vui lòng đăng nhập để đăng tin</h4>
                            <p class="text-muted mb-4">Bạn cần đăng nhập tài khoản để có thể đăng tin bất động sản.</p>
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </button>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">
                                <i class="fas fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('website.partials.footer')
    

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Back to top button
            const backToTop = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile navbar after click
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if(navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                        bsCollapse.hide();
                    }
                }
            });
        });
        
        // Back to top functionality
        document.getElementById('backToTop').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Add active class to current nav item
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        
        window.addEventListener('scroll', function() {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if(scrollY >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if(link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
        
        // Tab switching
        const projectsTab = document.getElementById('pills-projects-tab');
        const listingsTab = document.getElementById('pills-listings-tab');
        
        // Check URL hash on page load
        window.addEventListener('load', function() {
            if(window.location.hash === '#listings') {
                listingsTab.click();
            }
        });
        
        // Animation on scroll
        const animateElements = document.querySelectorAll('.animate-on-scroll');
        
        const animateOnScroll = function() {
            animateElements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if(elementPosition < screenPosition) {
                    element.classList.add('animated');
                }
            });
        };
        
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
        
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const rememberMe = document.getElementById('rememberMe').checked;
            
            // Hiệu ứng loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng nhập...';
            submitBtn.disabled = true;
            
            // Gửi request Ajax
            $.ajax({
                url: '{{ route("user.login") }}',
                method: 'POST',
                data: {
                    email: email,
                    password: password,
                    remember: rememberMe
                },
                success: function(response) {
                    if (response.success) {
                        // Hiển thị thông báo thành công trong modal
                        const modalBody = document.querySelector('#loginModal .modal-body');
                        const successMessage = document.createElement('div');
                        successMessage.className = 'alert alert-success';
                        successMessage.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>
                            ${response.message}
                        `;
                        
                        modalBody.insertBefore(successMessage, modalBody.firstChild);
                        
                        // Reload trang sau 1.5 giây để cập nhật trạng thái đăng nhập
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    // Hiển thị lỗi
                    const modalBody = document.querySelector('#loginModal .modal-body');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger';
                    errorDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle me-2"></i>
                        ${response.message || 'Đăng nhập thất bại. Vui lòng thử lại!'}
                    `;
                    
                    // Xóa thông báo lỗi cũ nếu có
                    const oldAlert = modalBody.querySelector('.alert');
                    if (oldAlert) oldAlert.remove();
                    
                    modalBody.insertBefore(errorDiv, modalBody.firstChild);
                    
                    // Tự động ẩn thông báo lỗi sau 5 giây
                    setTimeout(() => {
                        errorDiv.remove();
                    }, 5000);
                }
            });
        });
            
        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const phone = document.getElementById('registerPhone').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Kiểm tra mật khẩu khớp
            if (password !== confirmPassword) {
                alert('Mật khẩu xác nhận không khớp!');
                return;
            }
            
            // Hiệu ứng loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng ký...';
            submitBtn.disabled = true;
            
            // Gửi request Ajax
            $.ajax({
                url: '{{ route("user.register") }}',
                method: 'POST',
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    password: password,
                    password_confirmation: confirmPassword
                },
                success: function(response) {
                    if (response.success) {
                        // Hiển thị thông báo thành công
                        const modalBody = document.querySelector('#registerModal .modal-body');
                        const successMessage = document.createElement('div');
                        successMessage.className = 'alert alert-success';
                        successMessage.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>
                            ${response.message}
                        `;
                        
                        modalBody.insertBefore(successMessage, modalBody.firstChild);
                        
                        // Reset form
                        document.getElementById('registerForm').reset();
                        
                        // Tự động chuyển sang modal login sau 2 giây
                        setTimeout(() => {
                            const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                            registerModal.hide();
                            
                            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                            loginModal.show();
                            
                            // Điền email vào form login
                            document.getElementById('loginEmail').value = email;
                            
                            // Xóa thông báo thành công
                            successMessage.remove();
                        }, 2000);
                    }
                    
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    // Hiển thị lỗi validation
                    const modalBody = document.querySelector('#registerModal .modal-body');
                    let errorHtml = '<div class="alert alert-danger">';
                    errorHtml += '<i class="fas fa-exclamation-circle me-2"></i>';
                    
                    if (response.errors) {
                        // Hiển thị tất cả lỗi validation
                        for (const field in response.errors) {
                            errorHtml += `<div>${response.errors[field][0]}</div>`;
                        }
                    } else {
                        errorHtml += response.message || 'Đăng ký thất bại. Vui lòng thử lại!';
                    }
                    
                    errorHtml += '</div>';
                    
                    // Xóa thông báo lỗi cũ nếu có
                    const oldAlert = modalBody.querySelector('.alert');
                    if (oldAlert) oldAlert.remove();
                    
                    modalBody.insertBefore(document.createRange().createContextualFragment(errorHtml), modalBody.firstChild);
                    
                    // Tự động ẩn thông báo lỗi sau 5 giây
                    setTimeout(() => {
                        const errorDiv = modalBody.querySelector('.alert-danger');
                        if (errorDiv) errorDiv.remove();
                    }, 5000);
                }
            });
        });
        
        // Sửa URL trong xử lý form đăng tin
        $('#postForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Hiệu ứng loading
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang đăng tin...');
            submitBtn.prop('disabled', true);
            
            // Gửi request Ajax - sửa URL thành route mới
            $.ajax({
                url: '{{ route("user.listings.store") }}', // Đổi thành route mới
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Hiển thị thông báo thành công
                        const modalBody = $('#postModal .modal-body');
                        $('.alert', modalBody).remove();
                        
                        const successMessage = `
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                ${response.message}
                                <div class="mt-2">
                                    <a href="${response.redirect || '#'}" class="btn btn-sm btn-outline-success">
                                        Xem tin đã đăng
                                    </a>
                                </div>
                            </div>
                        `;
                        
                        $(successMessage).prependTo(modalBody);
                        
                        // Reset form
                        $('#postForm')[0].reset();
                        $('#imagePreview').empty();
                        
                        // Đóng modal sau 3 giây
                        // setTimeout(() => {
                        //     const postModal = bootstrap.Modal.getInstance(document.getElementById('postModal'));
                        //     if (postModal) postModal.hide();
                            
                        //     // Chuyển hướng nếu có
                        //     if (response.redirect) {
                        //         window.location.href = response.redirect;
                        //     }
                        // }, 3000);
                    }
                    
                    // Reset button
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    
                    // Reset button
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                    
                    // Hiển thị lỗi
                    const modalBody = $('#postModal .modal-body');
                    $('.alert', modalBody).remove();
                    
                    let errorHtml = '<div class="alert alert-danger">';
                    errorHtml += '<i class="fas fa-exclamation-circle me-2"></i>';
                    
                    if (response.errors) {
                        // Hiển thị tất cả lỗi validation
                        errorHtml += '<strong>Vui lòng kiểm tra các lỗi sau:</strong><ul class="mb-0 mt-2">';
                        for (const field in response.errors) {
                            errorHtml += `<li>${response.errors[field][0]}</li>`;
                        }
                        errorHtml += '</ul>';
                    } else {
                        errorHtml += response.message || 'Đăng tin thất bại. Vui lòng thử lại!';
                    }
                    
                    errorHtml += '</div>';
                    
                    $(errorHtml).prependTo(modalBody);
                    
                    // Tự động ẩn thông báo lỗi sau 5 giây
                    setTimeout(() => {
                        $('.alert-danger', modalBody).remove();
                    }, 5000);
                }
            });
        });
        
        // Xử lý form đăng ký nhận tin
        document.getElementById('subscribeForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Lấy giá trị từ form
            const name = this.querySelector('input[type="text"]').value;
            const email = this.querySelector('input[type="email"]').value;
            const agreeTerms = document.getElementById('agreeTerms').checked;
            
            if (!agreeTerms) {
                alert('Vui lòng đồng ý với điều khoản nhận thông tin');
                return;
            }
            
            // Hiệu ứng loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng ký...';
            submitBtn.disabled = true;
            
            // Giả lập gửi dữ liệu
            setTimeout(() => {
                // Hiển thị thông báo thành công
                const successMessage = document.createElement('div');
                successMessage.className = 'alert alert-success mt-3';
                successMessage.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Đăng ký thành công!</strong> Cảm ơn ${name} đã đăng ký nhận tin từ Nhà Đẹp. 
                    Chúng tôi sẽ gửi thông tin mới nhất đến email ${email}.
                `;
                
                this.parentNode.insertBefore(successMessage, this.nextSibling);
                
                // Reset form
                this.reset();
                document.getElementById('agreeTerms').checked = true;
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Ẩn thông báo sau 5 giây
                setTimeout(() => {
                    successMessage.remove();
                }, 5000);
            }, 1500);
        });
        
        // Tab click to scroll to section
        projectsTab.addEventListener('click', function() {
            setTimeout(() => {
                document.getElementById('section-tabs').scrollIntoView({behavior: 'smooth', block: 'start'});
            }, 100);
        });
        
        listingsTab.addEventListener('click', function() {
            setTimeout(() => {
                document.getElementById('section-tabs').scrollIntoView({behavior: 'smooth', block: 'start'});
            }, 100);
        });
    </script>
    @stack('scripts')
</body>
</html>
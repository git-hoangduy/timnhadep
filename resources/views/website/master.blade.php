<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <div class="text-center mt-3">
                        <p>Hoặc đăng nhập bằng</p>
                        <button class="btn btn-outline-primary me-2"><i class="fab fa-facebook-f"></i> Facebook</button>
                        <button class="btn btn-outline-danger"><i class="fab fa-google"></i> Google</button>
                    </div>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Họ và tên đệm</label>
                                <input type="text" class="form-control" id="firstName" placeholder="Nhập họ và tên đệm" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Tên</label>
                                <input type="text" class="form-control" id="lastName" placeholder="Nhập tên" required>
                            </div>
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
                    <form id="postForm">
                        <div class="mb-3">
                            <label for="postTitle" class="form-label">Tiêu đề tin đăng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="postTitle" placeholder="Ví dụ: Cần bán căn hộ chung cư 70m² tại Sunshine City" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="propertyType" class="form-label">Loại bất động sản <span class="text-danger">*</span></label>
                                <select class="form-select" id="propertyType" required>
                                    <option value="">Chọn loại bất động sản</option>
                                    <option value="apartment">Căn hộ chung cư</option>
                                    <option value="house">Nhà phố</option>
                                    <option value="villa">Biệt thự</option>
                                    <option value="land">Đất nền</option>
                                    <option value="office">Văn phòng</option>
                                    <option value="shop">Mặt bằng kinh doanh</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="transactionType" class="form-label">Hình thức <span class="text-danger">*</span></label>
                                <select class="form-select" id="transactionType" required>
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
                                <input type="number" class="form-control" id="price" placeholder="Nhập giá" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="area" class="form-label">Diện tích (m²) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="area" placeholder="Nhập diện tích" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" placeholder="Nhập địa chỉ chi tiết" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" rows="4" placeholder="Mô tả chi tiết về bất động sản: số phòng, hướng nhà, tiện ích, nội thất..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="images" multiple accept="image/*">
                            <div class="form-text">Tối đa 10 hình ảnh, dung lượng mỗi hình dưới 5MB</div>
                        </div>
                        <div class="mb-3">
                            <label for="contactName" class="form-label">Tên liên hệ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contactName" placeholder="Nhập tên người liên hệ" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactPhone" class="form-label">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="contactPhone" placeholder="Nhập số điện thoại" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Đăng tin ngay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('website.partials.footer')
    

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
        
        // Form submissions
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Đăng nhập thành công!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            modal.hide();
        });
        
        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Đăng ký tài khoản thành công! Vui lòng kiểm tra email để xác nhận.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
            modal.hide();
        });
        
        document.getElementById('postForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Tin đăng của bạn đã được gửi thành công! Tin sẽ được duyệt trong vòng 24 giờ.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('postModal'));
            modal.hide();
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
</body>
</html>
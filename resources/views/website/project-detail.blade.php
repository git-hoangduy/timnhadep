<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }}</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css">
    <link rel="stylesheet" href="{{ asset('website/css/style2.css') }}">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-transparent fixed-top">
            <div class="container">
                <a class="navbar-brand" href="index.html">{{ $project->name }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        @foreach ($project->blocks as $key => $block)
                            <li class="nav-item">
                                <a class="nav-link {{ $key == 0 ? 'active' : '' }}" href="#block_{{ $block->id }}">{{ $block->block_name }}</a>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="#news">TIN TỨC</a>
                        </li>
                    </ul>
                    <div class="user-actions">
                        <button class="btn btn-contact" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="fas fa-phone-alt me-2"></i>Liên hệ ngay
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-fullscreen" id="hero">
        <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Sunshine City Hero" class="parallax-bg" data-speed="0.5">
        
        <!-- Thêm overlay để xử lý khoảng đen khi scroll -->
        <div class="hero-overlay"></div>
        
        <div class="hero-content-center">
            <h1 class="project-title-main animate__animated animate__fadeInUp">{{ $project->name }}</h1>
            <p class="project-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ $project->excerpt }}</p>
        </div>
        
        <div class="scroll-indicator animate__animated animate__bounce animate__infinite">
            <i class="fas fa-chevron-down fa-3x"></i>
        </div>
    </section>

    <!-- Transition fix -->
    <div class="section-transition-fix"></div>

    <!-- Section Navigation Dots -->
    <div class="section-nav">
        @foreach ($project->blocks as $key => $block)
            <div class="section-dot {{ $key === 0 ? 'active' : '' }}" data-target="block_{{ $block->id }}">
                <span class="dot-tooltip">{{ $block->block_name }}</span>
            </div>
        @endforeach
        <div class="section-dot" data-target="news">
            <span class="dot-tooltip">TIN TỨC</span>
        </div>
    </div>

    <!-- Main Content -->
    <main>

        @foreach ($project->blocks as $key => $block)
            <section id="block_{{ $block->id }}" class="parallax-section">
                <img src="{{ asset($block->block_image) }}" 
                    alt="Overview Background" class="section-bg-parallax" data-speed="0.7">
                <div class="section-overlay overlay-dark"></div>
                
                <div class="section-content">
                    <div class="section-content-inner">
                        <h2 class="section-title">{{ $block->block_name }}</h2>
                        
                        <div class="tinymce-content">
                            {!! $block->block_content !!}
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        <!-- News Section -->
        <section class="news-section" id="news">
            <div class="container">
                <h2 class="section-title center">Tin tức bất động sản</h2>
                <p class="text-center text-muted mb-5">Cập nhật tin tức mới nhất về thị trường bất động sản, chính sách và xu hướng đầu tư</p>
                
                <div class="row">

                    @foreach($recentPosts as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card animate-on-scroll">
                            <div class="news-img">
                                <img src="{{ asset($post->image ?? '') }}" alt="{{ $post->name }}">
                                <div class="news-category">{{ $post->category->name }}</div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span class="news-date"><i class="far fa-calendar-alt me-1"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                                    <span class="news-author"><i class="far fa-user me-1"></i> Tìm nhà đẹp</span>
                                </div>
                                <h3 class="news-title">{{ $post->name }}</h3>
                                <p class="news-excerpt">{{ $post->excerpt }}</p>
                                <a href="{{ route('post.detail', $post->slug) }}" class="news-link">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
                
                <div class="text-center mt-5">
                    <a href="#" class="btn btn-outline-primary btn-lg">Xem tất cả tin tức <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="newsletter-section" id="newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-title center">Đăng ký nhận tin</h2>
                        <p class="mb-4">Nhận thông tin mới nhất về dự án bất động sản, tin tức thị trường và ưu đãi đặc biệt từ Nhà Đẹp</p>
                        
                        <div class="newsletter-form animate-on-scroll">
                            <form id="subscribeForm" class="row g-3 justify-content-center">
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-lg" placeholder="Họ và tên của bạn" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="email" class="form-control form-control-lg" placeholder="Địa chỉ email" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 px-2">Đăng ký</button>
                                </div>
                            </form>
                            
                            <!-- <div class="form-check mt-4">
                                <input type="checkbox" class="form-check-input" id="agreeTerms" checked>
                                <label class="form-check-label" for="agreeTerms">
                                    Tôi đồng ý nhận thông tin qua email và có thể hủy đăng ký bất cứ lúc nào
                                </label>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5>Nhà Đẹp</h5>
                    <p class="mb-4">Kênh bất động sản số 1 Việt Nam, kết nối người mua và người bán, cung cấp thông tin dự án chính xác và đầy đủ nhất.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h5>Liên kết</h5>
                    <ul class="footer-links">
                        <li><a href="index.html#home">Trang chủ</a></li>
                        <li><a href="index.html#projects">Dự án</a></li>
                        <li><a href="index.html#listings">Mua bán</a></li>
                        <li><a href="index.html#news">Tin tức</a></li>
                        <li><a href="index.html#about">Về chúng tôi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5>Dịch vụ</h5>
                    <ul class="footer-links">
                        <li><a href="#">Đăng tin miễn phí</a></li>
                        <li><a href="#">Tư vấn bất động sản</a></li>
                        <li><a href="#">Định giá bất động sản</a></li>
                        <li><a href="#">Pháp lý bất động sản</a></li>
                        <li><a href="#">Tin tức thị trường</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Liên hệ</h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Nguyễn Văn Linh, Quận 7, TP.HCM</li>
                        <li><i class="fas fa-phone me-2"></i> (028) 1234 5678</li>
                        <li><i class="fas fa-envelope me-2"></i> info@nhadep.com</li>
                        <li><i class="fas fa-clock me-2"></i> Thứ 2 - CN: 8:00 - 20:00</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="copyright">
                        <p>&copy; 2023 Nhà Đẹp. Tất cả các quyền được bảo lưu. | <a href="#" class="text-white-50">Chính sách bảo mật</a> | <a href="#" class="text-white-50">Điều khoản sử dụng</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
    
    <script>
        // ========== INITIALIZATIONS ==========
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            autoplayVideos: true
        });

        // ========== GALLERY FUNCTIONALITY ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Simple Gallery
            const mainImage = document.getElementById('mainGalleryImage');
            const thumbnails = document.querySelectorAll('.thumbnail');
            const prevBtn = document.querySelector('.gallery-prev');
            const nextBtn = document.querySelector('.gallery-next');
            const currentImageSpan = document.getElementById('currentImage');
            const totalImagesSpan = document.getElementById('totalImages');
            
            let currentIndex = 0;
            totalImagesSpan.textContent = thumbnails.length;
            
            // Thumbnail click
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener('click', function() {
                    updateGallery(index);
                });
            });
            
            // Previous button
            prevBtn.addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
                updateGallery(currentIndex);
            });
            
            // Next button
            nextBtn.addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % thumbnails.length;
                updateGallery(currentIndex);
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    prevBtn.click();
                } else if (e.key === 'ArrowRight') {
                    nextBtn.click();
                }
            });
            
            function updateGallery(index) {
                // Update active thumbnail
                thumbnails.forEach(t => t.classList.remove('active'));
                thumbnails[index].classList.add('active');
                
                // Update main image
                const imageUrl = thumbnails[index].getAttribute('data-image');
                mainImage.style.opacity = '0.7';
                
                setTimeout(() => {
                    mainImage.src = imageUrl;
                    mainImage.style.opacity = '1';
                }, 200);
                
                // Update current index
                currentImageSpan.textContent = index + 1;
                currentIndex = index;
            }
            
            // Hover effect on main image
            mainImage.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            mainImage.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // ========== PARALLAX EFFECT ==========
        function initParallax() {
            const parallaxElements = document.querySelectorAll('.parallax-bg, .section-bg-parallax');
            
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                
                parallaxElements.forEach(element => {
                    const speed = element.getAttribute('data-speed') || 0.5;
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translate3d(0, ${yPos}px, 0)`;
                });
            });
        }

        // ========== HEADER SCROLL EFFECT ==========
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-transparent');
            const backToTop = document.getElementById('backToTop');
            
            // Hiển thị header với background khi scroll xuống
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Hiển thị nút back to top
            if (window.scrollY > 500) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
            
            updateSectionDots();
        });

        // ========== SECTION NAVIGATION DOTS ==========
        const sectionDots = document.querySelectorAll('.section-dot');
        const sections = document.querySelectorAll('.parallax-section, .hero-fullscreen');

        function updateSectionDots() {
            let currentSection = '';
            let maxVisible = 0;
            
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                const visibleHeight = Math.min(rect.bottom, window.innerHeight) - Math.max(rect.top, 0);
                
                if (visibleHeight > maxVisible) {
                    maxVisible = visibleHeight;
                    currentSection = section.id;
                }
            });

            sectionDots.forEach(dot => {
                dot.classList.remove('active');
                if (dot.getAttribute('data-target') === currentSection) {
                    dot.classList.add('active');
                }
            });
        }

        // Smooth scroll to section
        sectionDots.forEach(dot => {
            dot.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // ========== NAVIGATION MENU CLICK ==========
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);
                    
                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // ========== BACK TO TOP ==========
        document.getElementById('backToTop').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // ========== SCROLL INDICATOR ==========
        document.querySelector('.scroll-indicator').addEventListener('click', function() {
            const overviewSection = document.getElementById('overview');
            window.scrollTo({
                top: overviewSection.offsetTop,
                behavior: 'smooth'
            });
        });

        // ========== ANIMATIONS ==========
        window.addEventListener('load', function() {
            initParallax();
            updateSectionDots();
            
            // Animate sections on scroll
            const animateElements = document.querySelectorAll('.section-content-inner');
            
            const animateOnScroll = function() {
                animateElements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.2;
                    
                    if(elementPosition < screenPosition) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Set initial state
            animateElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(40px)';
                element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            });
            
            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll();
            
            // Animate stats counter
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const target = parseInt(stat.textContent);
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        stat.textContent = stat.textContent;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.round(current);
                    }
                }, 20);
            });
        });

        // ========== NEWSLETTER FORM ==========
        document.getElementById('subscribeForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = this.querySelector('input[type="text"]').value;
            const email = this.querySelector('input[type="email"]').value;
            const agreeTerms = document.getElementById('agreeTerms').checked;
            
            if (!agreeTerms) {
                alert('Vui lòng đồng ý với điều khoản nhận thông tin');
                return;
            }
            
            // Loading effect
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng ký...';
            submitBtn.disabled = true;
            
            // Simulate form submission
            setTimeout(() => {
                // Success message
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
                
                // Remove message after 5 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 5000);
            }, 1500);
        });
    </script>
</body>
</html>
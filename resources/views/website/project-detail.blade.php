<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }} - {{ $project->slogan }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset(setting('info.shortcut')) }}">
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css">
    <link rel="stylesheet" href="{{ asset('website/css/style2.css') }}?v=20251224">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-transparent fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{route('project.detail', ['slug' => $project->slug])}}">
                    {{ $project->name }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">TRANG CHỦ</a>
                        </li>
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
                        <a class="btn btn-contact" href="tel:{{ setting('info.hotline') }}">
                            <i class="fas fa-phone-alt me-2"></i>Liên hệ ngay
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <!-- <section class="hero-fullscreen" id="hero">
        <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Sunshine City Hero" class="parallax-bg" data-speed="0.5">
        
        <div class="hero-overlay"></div>
        
        <div class="hero-content-center">
            @if ($project->logo)
                <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="logo" width="180">
            @else
                <h1 class="project-title-main animate__animated animate__fadeInUp">{{ $project->name }}</h1>
            @endif
            <p class="project-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ $project->excerpt }}</p>
        </div>
        
        <div class="scroll-indicator animate__animated animate__bounce animate__infinite">
            <i class="fas fa-chevron-down fa-3x"></i>
        </div>
    </section> -->

    <!-- Hero Section -->
    <section class="hero-fullscreen" id="hero">
        <!-- Simple image slider with parallax container -->
        <div class="hero-parallax-container">
            @if(isset($project->images) && count($project->images) > 0)
                @foreach($project->images as $index => $image)
                    <img src="{{ asset($image->image) }}" 
                        alt="{{ $project->name }} - Image {{ $index + 1 }}" 
                        class="parallax-bg slide-img {{ $index === 0 ? 'active' : '' }}"
                        data-speed="0.5">
                @endforeach
            @else
                <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                    alt="{{ $project->name }}" 
                    class="parallax-bg slide-img active"
                    data-speed="0.5">
            @endif
        </div>
        
        <!-- Thêm overlay để xử lý khoảng đen khi scroll -->
        <div class="hero-overlay"></div>
        
        <div class="hero-content-center">
            @if ($project->logo)
                <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="logo" width="180">
            @else
                <h1 class="project-title-main animate__animated animate__fadeInUp">{{ $project->name }}</h1>
            @endif
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
                @if ($block->block_image != '')
                <img src="{{ asset($block->block_image) }}" 
                    alt="Overview Background" class="section-bg-parallax" data-speed="0.7">
                @endif
                <div class="section-overlay overlay-dark"></div>
                
                <div class="section-content">
                    <div class="section-content-inner">
                        <h2 class="section-title">{{ $block->block_name }}</h2>
                        
                        <div class="tinymce-content">
                            {!! renderContent($block->block_content) !!}
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
                        <h2 class="section-title center">Đăng ký nhận tin & Tư vấn dự án</h2>
                        <p class="mb-4">Nhận thông tin mới nhất về dự án <strong>{{ $project->name }}</strong>, tin tức thị trường và ưu đãi đặc biệt</p>
                        
                        <div class="newsletter-form animate-on-scroll">
                            <form id="subscribeForm" method="POST" action="{{ route('contact') }}" class="row g-3 justify-content-center">
                                @csrf
                                <!-- Hidden field for project name -->
                                <input type="hidden" name="message" value="Tư vấn dự án {{ $project->name }}">
                                
                                <div class="col-md-4">
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Họ và tên của bạn" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="tel" name="phone" class="form-control form-control-lg" placeholder="Số điện thoại" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Địa chỉ email" required>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="form-check d-flex align-items-center justify-content-center gap-2">
                                        <input
                                            type="checkbox"
                                            class="form-check-input mt-0"
                                            id="agreeTerms"
                                            name="agree_terms"
                                            value="1"
                                            checked
                                            required
                                        >
                                        <label class="form-check-label mb-0" for="agreeTerms">
                                            Tôi đồng ý nhận thông tin qua email và có thể hủy đăng ký bất cứ lúc nào
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-paper-plane me-2"></i>Gửi yêu cầu tư vấn
                                    </button>
                                </div>
                            </form>
                            
                            <!-- <div class="mt-4 text-muted small">
                                <p><i class="fas fa-info-circle me-1"></i> Chúng tôi sẽ liên hệ lại trong vòng 24h để tư vấn chi tiết về dự án {{ $project->name }}</p>
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
                    <h5>{{ setting('info.name', 'Nhà Đẹp') }}</h5>
                    <p class="mb-4">{{ setting('info.description', 'Kênh bất động sản số 1 Việt Nam, kết nối người mua và người bán, cung cấp thông tin dự án chính xác và đầy đủ nhất.') }}</p>
                    <div class="social-links">
                        <a href="{{ setting('social.facebook', '#') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ setting('social.tiktok', '#') }}" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="{{ setting('social.instagram', '#') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="{{ setting('social.youtube', '#') }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        <!-- <a href="{{ setting('social.linkedin', '#') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a> -->
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h5>Liên kết</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Trang chủ</a></li>
                        <li><a href="{{ route('project') }}">Dự án</a></li>
                        <li><a href="{{ route('listing') }}">Mua bán</a></li>
                        <li><a href="{{ route('post') }}">Tin tức</a></li>
                        <li><a href="{{ route('page', $pages->where('id', 1)->first()->slug ?? '#') }}">Về chúng tôi</a></li>
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
                        <li><i class="fas fa-map-marker-alt me-2"></i> {{ setting('info.address', '123 Nguyễn Văn Linh, Quận 7, TP.HCM') }}</li>
                        <li><i class="fas fa-phone me-2"></i> {{ setting('info.hotline', '(028) 1234 5678') }}</li>
                        <li><i class="fas fa-envelope me-2"></i> {{ setting('info.email', 'info@nhadep.com') }}</li>
                        <li><i class="fas fa-clock me-2"></i> {{ setting('info.time', 'Thứ 2 - CN: 8:00 - 20:00') }}</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="copyright">
                        <p>{{ setting('info.copyright', '© 2023 Nhà Đẹp. Tất cả các quyền được bảo lưu.') }} | 
                        <a href="{{ route('page', $pages->where('id', 2)->first()->slug ?? '#') }}" class="text-white-50">Chính sách bảo mật</a> | 
                        <a href="{{ route('page', $pages->where('id', 3)->first()->slug ?? '#') }}" class="text-white-50">Điều khoản sử dụng</a></p>
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
        document.addEventListener('DOMContentLoaded', function () {

            function initGallery(gallery) {

                const mainImage = gallery.querySelector('.main-gallery-image');
                const thumbnails = gallery.querySelectorAll('.thumbnail');
                const prevBtn = gallery.querySelector('.gallery-prev');
                const nextBtn = gallery.querySelector('.gallery-next');
                const currentSpan = gallery.querySelector('.currentImage');

                if (!mainImage || thumbnails.length === 0) return;

                let currentIndex = [...thumbnails].findIndex(t => t.classList.contains('active'));
                if (currentIndex < 0) currentIndex = 0;

                function update(index) {
                    thumbnails.forEach(t => t.classList.remove('active'));
                    thumbnails[index].classList.add('active');

                    mainImage.style.opacity = '0.6';

                    setTimeout(() => {
                        mainImage.src = thumbnails[index].dataset.image;
                        mainImage.style.opacity = '1';
                    }, 200);

                    currentIndex = index;
                    if (currentSpan) currentSpan.textContent = index + 1;
                }

                thumbnails.forEach((thumb, index) => {
                    thumb.addEventListener('click', () => update(index));
                });

                prevBtn?.addEventListener('click', () => {
                    update((currentIndex - 1 + thumbnails.length) % thumbnails.length);
                });

                nextBtn?.addEventListener('click', () => {
                    update((currentIndex + 1) % thumbnails.length);
                });

                // Hover zoom
                mainImage.addEventListener('mouseenter', () => {
                    mainImage.style.transform = 'scale(1.02)';
                });

                mainImage.addEventListener('mouseleave', () => {
                    mainImage.style.transform = 'scale(1)';
                });
            }

            // Init all galleries
            document.querySelectorAll('.gallery').forEach(initGallery);

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
            
            // Validate form
            const name = this.querySelector('input[name="name"]').value;
            const phone = this.querySelector('input[name="phone"]').value;
            const email = this.querySelector('input[name="email"]').value;
            const agreeTerms = document.getElementById('agreeTerms').checked;
            
            if (!name || !phone || !email) {
                alert('Vui lòng điền đầy đủ thông tin');
                return;
            }
            
            if (!agreeTerms) {
                alert('Vui lòng đồng ý với điều khoản nhận thông tin');
                return;
            }
            
            // Phone validation (Vietnamese phone number)
            const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
            if (!phoneRegex.test(phone)) {
                alert('Vui lòng nhập số điện thoại hợp lệ');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Vui lòng nhập email hợp lệ');
                return;
            }
            
            // Loading effect
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
            submitBtn.disabled = true;
            
            // Submit form via AJAX
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.redirected) {
                    // If redirected (Laravel's redirect back)
                    return response.text().then(html => {
                        // Create a temporary div to parse the HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        
                        // Look for success/error messages in the response
                        const successMsg = tempDiv.querySelector('.alert-success');
                        const errorMsg = tempDiv.querySelector('.alert-error') || tempDiv.querySelector('.alert-danger');
                        
                        if (successMsg) {
                            showMessage('success', successMsg.textContent.trim());
                        } else if (errorMsg) {
                            showMessage('error', errorMsg.textContent.trim());
                        } else {
                            showMessage('success', 'Gửi yêu cầu thành công! Chúng tôi sẽ liên hệ lại sớm.');
                        }
                        
                        // Reset form
                        this.reset();
                        document.getElementById('agreeTerms').checked = true;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data && data.message) {
                    showMessage('success', data.message);
                    this.reset();
                    document.getElementById('agreeTerms').checked = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
            })
            .finally(() => {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
            
            function showMessage(type, text) {
                // Remove existing messages
                const existingMsg = document.querySelector('.form-message');
                if (existingMsg) existingMsg.remove();
                
                // Create message element
                const messageDiv = document.createElement('div');
                messageDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} mt-3 form-message`;
                messageDiv.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${text}
                `;
                
                // Insert after form
                const form = document.getElementById('subscribeForm');
                form.parentNode.insertBefore(messageDiv, form.nextSibling);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    messageDiv.remove();
                }, 5000);
            }
        });

        // ========== PARALLAX EFFECT UPDATED ==========
        function initParallax() {
            const parallaxElements = document.querySelectorAll('.parallax-bg');
            
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                
                parallaxElements.forEach(element => {
                    // Chỉ áp dụng parallax cho ảnh đang active
                    if (element.classList.contains('active')) {
                        const speed = element.getAttribute('data-speed') || 0.5;
                        const yPos = -(scrolled * speed);
                        element.style.transform = `translate3d(0, ${yPos}px, 0)`;
                    } else {
                        // Ẩn ảnh không active
                        element.style.transform = 'none';
                    }
                });
            });
        }

        // ========== SIMPLE IMAGE SLIDER ==========
        function initSimpleSlider() {
            const slides = document.querySelectorAll('.hero-parallax-container .slide-img');
            if (slides.length <= 1) return;
            
            let currentIndex = 0;
            
            function nextSlide() {
                // Hide current slide
                slides[currentIndex].classList.remove('active');
                
                // Move to next slide
                currentIndex++;
                if (currentIndex >= slides.length) {
                    currentIndex = 0;
                }
                
                // Show next slide
                slides[currentIndex].classList.add('active');
            }
            
            // Start auto slide every 3 seconds
            setInterval(nextSlide, 3000);
        }

        // ========== INITIALIZE ==========
        document.addEventListener('DOMContentLoaded', function() {
            initSimpleSlider();
            initParallax();
        });

        function parseBorderFromStyle(styleString) {
            const result = {
                width: '1px',
                style: 'solid',
                color: 'gray'
            };
            
            if (!styleString) return result;
            
            // Tìm border tổng hợp
            const borderMatch = styleString.match(/border:\s*([^;!]+)/i);
            if (borderMatch) {
                const parts = borderMatch[1].trim().split(/\s+/);
                if (parts.length >= 3) {
                    result.width = parts[0];
                    result.style = parts[1];
                    result.color = parts[2];
                }
            } else {
                // Tìm từng thuộc tính riêng
                const widthMatch = styleString.match(/border-width:\s*([^;!]+)/i);
                const styleMatch = styleString.match(/border-style:\s*([^;!]+)/i);
                const colorMatch = styleString.match(/border-color:\s*([^;!]+)/i);
                
                if (widthMatch) result.width = widthMatch[1].trim();
                if (styleMatch) result.style = styleMatch[1].trim();
                if (colorMatch) result.color = colorMatch[1].trim();
            }
            
            return result;
        }

        function fixTableAttributes() {
            document.querySelectorAll('.tinymce-content table').forEach(table => {
                // Parse border từ style hiện tại
                const currentStyle = table.getAttribute('style') || '';
                const borderInfo = parseBorderFromStyle(currentStyle);
                let newTableStyle = currentStyle;
                
                // 1. Xử lý border attribute
                if (table.hasAttribute('border')) {
                    const borderAttr = table.getAttribute('border');
                    
                    if (borderAttr === '0' || borderAttr === '') {
                        // Không border
                        newTableStyle += ' border: none !important;';
                        borderInfo.width = '0';
                    } else {
                        // Dùng kiểu và màu hiện tại, chỉ đổi width
                        newTableStyle += ` border: ${borderAttr}px ${borderInfo.style} ${borderInfo.color} !important;`;
                        borderInfo.width = `${borderAttr}px`;
                    }
                    table.removeAttribute('border');
                }
                
                // 2. Áp dụng border cho tất cả td, th (QUAN TRỌNG!)
                table.querySelectorAll('td, th').forEach(cell => {
                    let cellStyle = cell.getAttribute('style') || '';
                    
                    // Kiểm tra xem cell đã có border chưa
                    const hasBorder = cellStyle.includes('border:') || 
                                    cellStyle.includes('border-width:') ||
                                    cellStyle.includes('border-style:') ||
                                    cellStyle.includes('border-color:');
                    
                    if (!hasBorder && borderInfo.width !== '0') {
                        // Chưa có border, thêm border từ table
                        cellStyle += ` border: ${borderInfo.width} ${borderInfo.style} ${borderInfo.color} !important;`;
                    } else if (borderInfo.width === '0') {
                        // Table không border, cell cũng không border
                        cellStyle += ' border: none !important;';
                    }
                    
                    // 3. Xử lý cellpadding attribute
                    if (table.hasAttribute('cellpadding')) {
                        const padding = table.getAttribute('cellpadding');
                        cellStyle += ` padding: ${padding}px !important;`;
                    }
                    
                    // 4. Xử lý các attribute khác của cell
                    if (cell.hasAttribute('border')) {
                        const cellBorder = cell.getAttribute('border');
                        if (cellBorder === '0' || cellBorder === '') {
                            cellStyle += ' border: none !important;';
                        } else {
                            // Giữ style và color hiện tại, chỉ đổi width
                            const cellBorderInfo = parseBorderFromStyle(cellStyle);
                            cellStyle += ` border: ${cellBorder}px ${cellBorderInfo.style || borderInfo.style} ${cellBorderInfo.color || borderInfo.color} !important;`;
                        }
                        cell.removeAttribute('border');
                    }
                    
                    if (cell.hasAttribute('bgcolor')) {
                        cellStyle += ` background-color: ${cell.getAttribute('bgcolor')} !important;`;
                        cell.removeAttribute('bgcolor');
                    }
                    
                    if (cell.hasAttribute('width')) {
                        const width = cell.getAttribute('width');
                        cellStyle += ` width: ${width}${width.includes('%') ? '' : 'px'} !important;`;
                        cell.removeAttribute('width');
                    }
                    
                    if (cell.hasAttribute('height')) {
                        cellStyle += ` height: ${cell.getAttribute('height')}px !important;`;
                        cell.removeAttribute('height');
                    }
                    
                    if (cell.hasAttribute('align')) {
                        cellStyle += ` text-align: ${cell.getAttribute('align')} !important;`;
                        cell.removeAttribute('align');
                    }
                    
                    if (cell.hasAttribute('valign')) {
                        cellStyle += ` vertical-align: ${cell.getAttribute('valign')} !important;`;
                        cell.removeAttribute('valign');
                    }
                    
                    if (cellStyle !== cell.getAttribute('style')) {
                        cell.setAttribute('style', cellStyle);
                    }
                });
                
                // Xóa cellpadding khỏi table sau khi đã xử lý
                if (table.hasAttribute('cellpadding')) {
                    table.removeAttribute('cellpadding');
                }
                
                // 5. Xử lý cellspacing
                if (table.hasAttribute('cellspacing')) {
                    const spacing = table.getAttribute('cellspacing');
                    newTableStyle += ` border-collapse: separate !important; border-spacing: ${spacing}px !important;`;
                    table.removeAttribute('cellspacing');
                }
                
                // 6. Xử lý các attribute khác của table
                if (table.hasAttribute('bgcolor')) {
                    newTableStyle += ` background-color: ${table.getAttribute('bgcolor')} !important;`;
                    table.removeAttribute('bgcolor');
                }
                
                if (table.hasAttribute('width')) {
                    const width = table.getAttribute('width');
                    newTableStyle += ` width: ${width}${width.includes('%') ? '' : 'px'} !important;`;
                    table.removeAttribute('width');
                }
                
                if (table.hasAttribute('height')) {
                    newTableStyle += ` height: ${table.getAttribute('height')}px !important;`;
                    table.removeAttribute('height');
                }
                
                if (table.hasAttribute('align')) {
                    const align = table.getAttribute('align');
                    newTableStyle += ` float: ${align} !important; margin-${align === 'left' ? 'right' : 'left'}: 15px !important;`;
                    table.removeAttribute('align');
                }
                
                // Cập nhật style cho table
                if (newTableStyle !== currentStyle) {
                    table.setAttribute('style', newTableStyle);
                }
            });
        }

        // Chạy khi trang load
        document.addEventListener('DOMContentLoaded', fixTableAttributes);

        // Chạy lại sau 500ms để xử lý nội dung load sau
        setTimeout(fixTableAttributes, 500);
        
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/694e91ab096840197e574a21/1jddei220';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->
</body>
</html>
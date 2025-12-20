@extends('website.master')
@section('content')

<!-- Hero Section -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-content">
                    <h1 class="animate__animated animate__fadeInDown">Tìm Ngôi Nhà Hoàn Hảo Cho Gia Đình Bạn</h1>
                    <p class="animate__animated animate__fadeInUp animate__delay-1s">Khám phá hàng nghìn bất động sản cao cấp, đăng tin mua bán miễn phí và nhận tư vấn từ chuyên gia hàng đầu.</p>
                    <div class="animate__animated animate__fadeInUp animate__delay-2s">
                        <a href="#projects" class="btn btn-primary me-3 mb-3 mb-md-0"><i class="fas fa-building me-2"></i>Xem dự án</a>
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#postModal"><i class="fas fa-plus-circle me-2"></i>Đăng tin ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-stats animate__animated animate__fadeIn animate__delay-1s">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number">2,580+</div>
                                <div class="stat-text">Dự án bất động sản</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number">15,230+</div>
                                <div class="stat-text">Tin đăng mua bán</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number">8,940+</div>
                                <div class="stat-text">Khách hàng hài lòng</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number">98%</div>
                                <div class="stat-text">Giao dịch thành công</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tabs Navigation -->
<section class="section-tabs" id="section-tabs">
    <div class="container">
        <ul class="nav nav-pills tabs-navigation" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-projects-tab" data-bs-toggle="pill" data-bs-target="#pills-projects" type="button" role="tab">Dự án bất động sản</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-listings-tab" data-bs-toggle="pill" data-bs-target="#pills-listings" type="button" role="tab">Tin đăng mua bán</button>
            </li>
        </ul>
        
        <div class="tab-content" id="pills-tabContent">
            <!-- Projects Tab -->
            <div class="tab-pane fade show active" id="pills-projects" role="tabpanel">
                <div class="projects-section" id="projects">
                    <div class="container">
                        <h2 class="section-title center">Dự án nổi bật</h2>
                        <p class="text-center text-muted mb-5">Khám phá những dự án bất động sản cao cấp với vị trí đắc địa và tiện ích hoàn hảo</p>
                        
                        <div class="row">
                            @foreach($projects as $key => $item)
                                <div class="col-lg-4 col-md-6">
                                    <div class="project-card animate-on-scroll">
                                        <div class="project-img">
                                            <img src="{{ asset($item->avatar->image) }}" alt="{{$item->name}}">
                                            @if($key == 0)
                                                <div class="project-badge">
                                                    <span class="badge bg-primary">Mới</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="project-info">
                                            <h3 class="project-title">{{$item->name}}</h3>
                                            <div class="project-location">
                                                <i class="fas fa-map-marker-alt me-2"></i>{{$item->position}}
                                            </div>
                                            <div class="project-price">{{$item->price}}</div>
                                            <p class="mb-3">{{$item->excerpt}}</p>
                                            <a href="{{route('project.detail', ['slug' => $item->slug])}}" class="btn btn-primary w-100 mt-3">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-5">
                            <a href="{{route('project')}}" class="btn btn-outline-primary btn-lg">Xem tất cả dự án <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Listings Tab -->
            <div class="tab-pane fade" id="pills-listings" role="tabpanel">
                <div class="post-listing-section" id="listings">
                    <div class="container">
                        <h2 class="section-title center">Đăng tin mua bán bất động sản</h2>
                        <p class="text-center text-muted mb-5">Đăng tin miễn phí, tiếp cận hàng nghìn khách hàng tiềm năng trong vài phút</p>
                        
                        <div class="row mb-5">
                            <div class="col-lg-4 col-md-6">
                                <div class="post-card animate-on-scroll">
                                    <div class="post-icon">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <h3>Tạo tài khoản</h3>
                                    <p>Đăng ký tài khoản miễn phí trong 2 phút để bắt đầu đăng tin mua bán bất động sản.</p>
                                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký ngay</button>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6">
                                <div class="post-card animate-on-scroll">
                                    <div class="post-icon">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <h3>Đăng tin miễn phí</h3>
                                    <p>Điền thông tin bất động sản của bạn, thêm hình ảnh và mô tả chi tiết để thu hút người xem.</p>
                                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#postModal">Đăng tin ngay</button>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6">
                                <div class="post-card animate-on-scroll">
                                    <div class="post-icon">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <h3>Kết nối & Giao dịch</h3>
                                    <p>Nhận liên hệ từ khách hàng tiềm năng, thương lượng và hoàn tất giao dịch một cách nhanh chóng.</p>
                                    <button class="btn btn-primary w-100">Tìm hiểu thêm</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Featured Listings -->
                        <div class="featured-listings" id="featured-listings">
                            <h2 class="section-title center">Tin đăng nổi bật</h2>
                            <p class="text-center text-muted mb-5">Khám phá những tin đăng mua bán mới nhất từ cộng đồng</p>
                            
                            <div class="row">
                                @foreach($listings as $listing)
                                <div class="col-lg-6">
                                    <div class="listing-card animate-on-scroll">
                                        <div class="listing-header">
                                            <div class="listing-user">
                                                <div class="user-avatar">
                                                    <img src="{{asset($listing->customer->avatar)}}" alt="{{ $listing->customer->name }}">
                                                </div>
                                                <div>
                                                    <div class="user-name">{{ $listing->customer->name }}</div>
                                                    <!-- <div class="user-rating">
                                                        <i class="fas fa-star text-warning"></i>
                                                        <i class="fas fa-star text-warning"></i>
                                                        <i class="fas fa-star text-warning"></i>
                                                        <i class="fas fa-star text-warning"></i>
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                        <span class="ms-1">4.5</span>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="listing-date">{{ $listing->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="listing-content">
                                            <h3 class="listing-title">{{ $listing->name }}</h3>
                                            <span class="listing-type">{{ $listing->category->name }}</span>
                                            <p class="listing-description">{{ $listing->excerpt }}</p>
                                            <div class="listing-price">{{ $listing->price }} VND</div>
                                        </div>
                                        <div class="listing-footer">
                                            <div class="listing-location">
                                                <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                                {{ $listing->position }}
                                            </div>
                                            <a href="{{route('listing.detail', ['slug' => $listing->slug])}}" class="btn btn-outline-primary btn-sm">Liên hệ ngay</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="text-center mt-5">
                                <a href="{{route('listing')}}" class="btn btn-outline-primary btn-lg">Xem tất cả tin đăng <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="news-section" id="news">
    <div class="container">
        <h2 class="section-title center">Tin tức bất động sản</h2>
        <p class="text-center text-muted mb-5">Cập nhật tin tức mới nhất về thị trường bất động sản, chính sách và xu hướng đầu tư</p>
        
        <div class="row">

            @foreach($posts as $key => $item)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card animate-on-scroll">
                        <div class="news-img">
                            <img src="{{ asset($item->image) }}" alt="Thị trường bất động sản 2023">
                            <div class="news-category">{{ $item->category->name }}</div>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-date"><i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('d/m/Y') }}</span>
                                <span class="news-author"><i class="far fa-user me-1"></i> Tìm nhà đẹp</span>
                            </div>
                            <h3 class="news-title">{{ $item->name }}</h3>
                            <p class="news-excerpt">{{ $item->excerpt }}</p>
                            <a href="{{route('post.detail', ['slug' => $item->slug])}}" class="news-link">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
        
        <div class="text-center mt-5">
            <a href="{{route('post')}}" class="btn btn-outline-primary btn-lg">Xem tất cả tin tức <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="about-img-wrapper">
                    <div class="about-img-main">
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Về Nhà Đẹp" class="img-fluid rounded">
                    </div>
                    <div class="about-img-secondary">
                        <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Đội ngũ chuyên nghiệp" class="img-fluid rounded">
                    </div>
                    <div class="experience-badge">
                        <div class="experience-years">10+</div>
                        <div class="experience-text">Năm kinh nghiệm</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Về Nhà Đẹp</h2>
                <p class="mb-4">Với hơn <strong>10 năm kinh nghiệm</strong> trong lĩnh vực bất động sản, <strong class="text-primary">Nhà Đẹp</strong> tự hào là đơn vị tư vấn và phân phối bất động sản uy tín hàng đầu tại Việt Nam.</p>
                <p class="mb-4">Chúng tôi chuyên tư vấn, môi giới và phân phối các dự án căn hộ, nhà phố, biệt thự cao cấp tại các thành phố lớn. Đội ngũ nhân viên chuyên nghiệp, am hiểu thị trường sẽ mang đến cho khách hàng những giải pháp đầu tư hiệu quả nhất.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Tư vấn chuyên sâu</h5>
                                    <p>Đội ngũ chuyên gia giàu kinh nghiệm</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Hỗ trợ pháp lý</h5>
                                    <p>Đảm bảo an toàn pháp lý cho giao dịch</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Đánh giá thị trường</h5>
                                    <p>Phân tích và đánh giá thị trường chính xác</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-item">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Đa dạng dự án</h5>
                                    <p>Hàng trăm dự án từ bình dân đến cao cấp</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Chăm sóc 24/7</h5>
                                    <p>Hỗ trợ khách hàng 24 giờ mỗi ngày</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Bảo mật thông tin</h5>
                                    <p>Cam kết bảo mật thông tin khách hàng</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="stats-container mt-5">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-number">2,580+</div>
                            <div class="stat-label">Dự án</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number">15,230+</div>
                            <div class="stat-label">Khách hàng</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Hài lòng</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
@endpush
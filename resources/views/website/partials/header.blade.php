<!-- Header -->
<!-- Header -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span>Tìm</span>NhàĐẹp
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('project') }}">Dự án</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('listing') }}">Mua bán</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post') }}">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('page', $pages->filter(function ($item) { return $item->id == 1; })->first()->slug) }}">Về chúng tôi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Liên hệ</a>
                    </li>
                </ul>
                <div class="user-actions">
                    @if(Auth::guard('customer')->check())
                        <!-- Hiển thị khi đã đăng nhập -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i> 
                                {{ Auth::guard('customer')->user()->name ?: Auth::guard('customer')->user()->email }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                                        <i class="fas fa-user-circle me-2"></i> Tài khoản
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.my-listings') }}">
                                        <i class="fas fa-shopping-cart me-2"></i> Tin đã đăng
                                    </a>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#postModal">
                                        <i class="fas fa-plus-circle me-2"></i> Đăng tin mới
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('user.logout') }}">
                                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Hiển thị khi chưa đăng nhập -->
                        <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </button>
                        <button class="btn btn-primary btn-register" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="fas fa-user-plus me-2"></i>Đăng ký
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
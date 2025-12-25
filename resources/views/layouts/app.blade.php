<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Admin') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/images/admin.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/huebee.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        @if (Auth::check())
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('contact.index') }}">
                        {{ config('app.name', 'Admin') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item dropdown d-none">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-bag-check"></i> Bán hàng
                                </a>
                                <div class="dropdown-menu columns-3">
                                    <div class="row">
                                        <div class="col-4">
                                            <h6 class="dropdown-header">Sản phẩm</h6>
                                            <a class="dropdown-item" href="{{ route('product.create') }}">
                                                Thêm sản phẩm
                                            </a>
                                            <a class="dropdown-item" href="{{ route('product.index') }}">
                                                Danh sách sản phẩm
                                            </a>
                                            <a class="dropdown-item" href="{{ route('product-category.index') }}">
                                                Danh mục sản phẩm
                                            </a>  
                                            <a class="dropdown-item" href="{{ route('brand.index') }}">
                                                Thương hiệu sản phẩm
                                            </a>
                                            {{-- <a class="dropdown-item" href="{{ route('attribute.index') }}">
                                                Thuộc tính sản phẩm
                                            </a> --}}
                                            <a class="dropdown-item" href="{{ route('review.index') }}">
                                                Đánh giá sản phẩm
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="dropdown-header">Đơn hàng</h6>
                                            <a class="dropdown-item" href="{{ route('order.create') }}">
                                                Tạo đơn hàng
                                            </a>
                                            <a class="dropdown-item" href="{{ route('order.index') }}">
                                                Danh sách đơn hàng <span id="count-new-orders" class="new d-none"></span>
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="dropdown-header">Cửa hàng</h6>
                                            <a class="dropdown-item" href="{{ route('coupon.index') }}">
                                                Mã giảm giá
                                            </a>
                                            <a class="dropdown-item" href="{{ route('campaign.index') }}">
                                                Chiến dịch
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle"></i> Khách hàng
                                    @if ($contact->count() > 0)
                                        <small class="bg-danger px-2 text-white rounded-pill">{{ $contact->count() }}</small>   
                                    @endif
                                </a>
                                <div class="dropdown-menu">
                                    <div class="row">
                                        <div class="col">
                                            <!-- <a class="dropdown-item" href="{{ route('customer.create') }}">
                                                Thêm khách hàng
                                            </a> -->
                                            <a class="dropdown-item" href="{{ route('customer.index') }}">
                                                Người đăng ký
                                            </a>
                                            <a class="dropdown-item" href="{{ route('contact.index') }}">
                                                Liên hệ, Yêu cầu 
                                                @if ($contact->count() > 0)
                                                    <small class="bg-danger px-2 text-white rounded-pill">{{ $contact->count() }}</small>   
                                                @endif
                                            </a>
                                            <!-- <a class="dropdown-item" href="{{ route('user.index') }}">
                                                Danh sách người dùng
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-clipboard-check"></i> Dự án
                                </a>
                                <div class="dropdown-menu columns-1">
                                    <div class="row">
                                        <div class="col">
                                            <a class="dropdown-item" href="{{ route('project.create') }}">
                                                Thêm dự án
                                            </a>
                                            <a class="dropdown-item" href="{{ route('project.index') }}">
                                                Danh sách dự án
                                            </a>
                                            <a class="dropdown-item" href="{{ route('project-category.index') }}">
                                                Danh mục dự án
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-clipboard-check"></i> Tin mua bán
                                </a>
                                <div class="dropdown-menu columns-1">
                                    <div class="row">
                                        <div class="col">
                                            <a class="dropdown-item" href="{{ route('listing.create') }}">
                                                Thêm tin
                                            </a>
                                            <a class="dropdown-item" href="{{ route('listing.index') }}">
                                                Danh sách tin
                                            </a>
                                            <a class="dropdown-item" href="{{ route('listing-category.index') }}">
                                                Danh mục tin
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-pencil-square"></i> Bài viết
                                </a>
                                <div class="dropdown-menu columns-1">
                                    <div class="row">
                                        <div class="col">
                                            <a class="dropdown-item" href="{{ route('post.create') }}">
                                                Thêm bài viết
                                            </a>
                                            <a class="dropdown-item" href="{{ route('post.index') }}">
                                                Danh sách bài viết
                                            </a>
                                            <a class="dropdown-item" href="{{ route('post-category.index') }}">
                                                Danh mục bài viết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-file-earmark"></i> Trang
                                </a>
                                <div class="dropdown-menu columns-1">
                                    <div class="row">
                                        <div class="col">
                                            <a class="dropdown-item" href="{{ route('page.create') }}">
                                                Thêm trang mới
                                            </a>
                                            <a class="dropdown-item" href="{{ route('page.index') }}">
                                                Danh sách trang
                                            </a> 
                                            <a class="dropdown-item" href="{{ route('page-category.index') }}">
                                                Danh mục tarng
                                            </a>
                                        </div>   
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-images"></i> Thiết kế
                                </a>
                                <div class="dropdown-menu">
                                    <div class="row">
                                        <div class="col">
                                            {{-- <a class="dropdown-item" href="{{ route('banner.index') }}">
                                                Banner
                                            </a> --}}
                                            {{-- <a class="dropdown-item" href="{{ route('feature.index') }}">
                                                Nổi bật
                                            </a> --}}
                                            <a class="dropdown-item" href="{{ route('album.index') }}">
                                                Album
                                            </a>
                                            <!-- <a class="dropdown-item" href="{{ route('review.index') }}">
                                                Đánh giá
                                            </a> -->
                                            {{-- <a class="dropdown-item" href="{{ route('video.index') }}">
                                                Video
                                            </a> --}}
                                            <!-- <a class="dropdown-item" href="{{ route('footer.index') }}">
                                                Footer
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-gear"></i> Cài đặt
                                </a>
                                <div class="dropdown-menu">
                                    <div class="row">
                                        <div class="col">
                                            <a class="dropdown-item" href="{{ route('setting.info') }}">
                                                Thông tin tổng quan
                                            </a>
                                            <a class="dropdown-item" href="{{ route('setting.social') }}">
                                                Trang mạng xã hội
                                            </a>
                                            <a class="dropdown-item" href="{{ route('setting.seo') }}">
                                                Thông tin SEO
                                            </a>
                                            {{-- <a class="dropdown-item" href="{{ route('bank.index') }}">
                                                Tài khoản ngân hàng
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                    Trang Web
                                </a>
                            </li> --}}
                        </ul>

                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="profileDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <img src="{{ asset('admin/images/user.png') }}" width="20" alt="{{ Auth::user()->name }}">
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="{{ route('change-password') }}">Đổi mật khẩu</a>
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                        Đăng xuất
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </nav>
        @endif
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/huebee.pkgd.min.js') }}"></script>
    <script src="{{ asset('admin/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin/js/tinymce-template.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/messages_vi.min.js') }}"></script>
    @if(request()->is('admin/project/*'))
        <script src="{{ asset('admin/js/custom2.js') }}"></script>
    @else
        <script src="{{ asset('admin/js/custom.js') }}"></script>
    @endif

    @stack('scripts')

    <script>
        
    </script>
</body>
</html>

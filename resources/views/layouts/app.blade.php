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
                    <a class="navbar-brand" href="{{ route('project.index') }}">
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
                            <li class="nav-item dropdown me-2">
                                <a id="notificationDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-regular fa-bell"></i>
                                    <span id="notificationBadge" class="badge bg-danger d-none" style="position: relative; top: -8px; left: -4px;"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 320px;">
                                    <div class="px-3 py-2 border-bottom fw-semibold d-flex align-items-center justify-content-between">
                                        <span>Thông báo mới</span>
                                        <a class="small text-decoration-none" href="{{ route('notification.index') }}">Xem thêm</a>
                                    </div>

                                    <div id="notificationList" class="py-1">
                                        <div class="dropdown-item text-center text-muted py-3">Đang tải...</div>
                                    </div>

                                    <div class="border-top">
                                        <a class="dropdown-item text-center" href="{{ route('notification.index') }}">Xem thêm</a>
                                    </div>
                                </div>
                            </li>
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
        function escapeHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function loadNotifications(options) {
            options = options || {};
            options.limit = typeof options.limit === 'number' ? options.limit : 10;
            options.onlyBadge = !!options.onlyBadge;
            options.includeLatest = options.onlyBadge ? true : !!options.includeLatest;
            var $list = $('#notificationList');
            var $badge = $('#notificationBadge');

            if (!$list.length) return;

            if (!options.silent && !options.onlyBadge) {
                $list.html('<div class="dropdown-item text-center text-muted py-3">Đang tải...</div>');
            }

            $.ajax({
                url: '{{ route('notification.list') }}',
                type: 'GET',
                data: {
                    limit: options.onlyBadge ? 0 : options.limit,
                    mark_read: options.markRead ? 1 : 0,
                    include_latest: options.includeLatest ? 1 : 0
                },
                success: function (res) {
                    if (!res || !res.success) {
                        if (!options.onlyBadge) {
                            $list.html('<div class="dropdown-item text-center text-muted py-3">Không tải được thông báo.</div>');
                        }
                        return;
                    }

                    var unread = parseInt(res.unread || 0, 10);
                    if (unread > 0) {
                        $badge.text(unread).removeClass('d-none');
                    } else {
                        $badge.text('').addClass('d-none');
                    }

                    if (options.onlyBadge) {
                        maybeShowBrowserNotification(res, unread);
                        return;
                    }

                    if (options.onlyBadge) return;

                    var items = Array.isArray(res.data) ? res.data : [];
                    if (!items.length) {
                        $list.html('<div class="dropdown-item text-center text-muted py-3">Chưa có thông báo.</div>');
                        return;
                    }

                    var html = '';
                    var maxId = 0;
                    items.forEach(function (n) {
                        var idNum = parseInt(n.id || 0, 10);
                        if (idNum > maxId) maxId = idNum;
                        var msg = escapeHtml(n.message || '');
                        var time = escapeHtml(n.time || '');
                        html += '<a class="dropdown-item py-2" href="#">'
                            + '<div class="d-flex flex-column">'
                            + '<span class="text-dark" style="white-space: normal;">' + msg + '</span>'
                            + '<small class="text-muted">' + time + '</small>'
                            + '</div>'
                            + '</a>';
                    });
                    $list.html(html);

                    // Prevent showing desktop notification for items user just saw.
                    if (maxId > 0) {
                        localStorage.setItem('notify_last_id', String(maxId));
                    }
                },
                error: function () {
                    if (!options.onlyBadge) {
                        $list.html('<div class="dropdown-item text-center text-muted py-3">Không tải được thông báo.</div>');
                    }
                }
            });
        }

        function browserNotifyEnabled() {
            return localStorage.getItem('notify_enabled') === '1';
        }

        function setBrowserNotifyEnabled(enabled) {
            localStorage.setItem('notify_enabled', enabled ? '1' : '0');
        }

        function getLastNotifiedId() {
            return parseInt(localStorage.getItem('notify_last_id') || '0', 10) || 0;
        }

        function setLastNotifiedId(id) {
            localStorage.setItem('notify_last_id', String(parseInt(id || 0, 10) || 0));
        }

        function shouldAskBrowserNotificationPermission() {
            if (!('Notification' in window)) return false;
            if (!window.isSecureContext) return false;
            if (Notification.permission !== 'default') return false;
            // Ask only once
            return localStorage.getItem('notify_asked') !== '1';
        }

        function askBrowserNotificationPermission() {
            if (!shouldAskBrowserNotificationPermission()) return;
            localStorage.setItem('notify_asked', '1');

            var ok = confirm('Bạn có muốn bật thông báo trình duyệt (Chrome) không?');
            if (!ok) {
                setBrowserNotifyEnabled(false);
                return;
            }

            Notification.requestPermission().then(function (permission) {
                if (permission === 'granted') {
                    setBrowserNotifyEnabled(true);
                    try {
                        new Notification('Đã bật thông báo', {
                            body: 'Bạn sẽ nhận thông báo khi có tin mới (khi đang mở trang admin).',
                            icon: '{{ asset('admin/images/admin.png') }}'
                        });
                    } catch (e) {}
                } else {
                    setBrowserNotifyEnabled(false);
                }
            });
        }

        function maybeShowBrowserNotification(res, unread) {
            if (!browserNotifyEnabled()) return;
            if (!('Notification' in window)) return;
            if (Notification.permission !== 'granted') return;

            var latest = res && res.latest ? res.latest : null;
            if (!latest || !latest.id) return;

            var lastId = getLastNotifiedId();
            var latestId = parseInt(latest.id || 0, 10);
            if (!latestId || latestId <= lastId) return;

            setLastNotifiedId(latestId);

            var title = 'Thông báo mới';
            var body = latest.message || '';
            if (unread && unread > 1) {
                body = body + '\n(' + unread + ' chưa xem)';
            }

            try {
                new Notification(title, {
                    body: body,
                    icon: '{{ asset('admin/images/admin.png') }}'
                });
            } catch (e) {}
        }

        $(function () {
            // Only run notifications logic when the admin navbar bell exists (avoid prompting on login page)
            if (!$('#notificationDropdown').length) return;

            askBrowserNotificationPermission();

            // Initial badge fetch
            loadNotifications({ silent: true, markRead: false, onlyBadge: true });

            // Poll unread count every 5s (only when tab is visible)
            setInterval(function () {
                if (document.visibilityState !== 'visible') return;
                loadNotifications({ silent: true, markRead: false, onlyBadge: true });
            }, 5000);

            // When user opens the dropdown, fetch list and mark those items as read
            $('#notificationDropdown').on('click', function () {
                loadNotifications({ markRead: true, onlyBadge: false, limit: 10 });
            });
        });
    </script>
</body>
</html>

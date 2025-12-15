<div class="header sticky-top">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset(setting('info.logo')) }}" width="184" height="60" alt="{{ asset(setting('info.name')) }}">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerMenu" aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="headerMenu">
                <ul class="navbar-nav me-auto">
                    @foreach ($pageCategories as $key => $category)
                        @if ($category->pages->count())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $category->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($category->pages as $page)
                                        <li><a class="dropdown-item" href="{{ route('page', $page->slug) }}">{{  $page->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ !$key ? 'active' : '' }}" aria-current="page" href="#">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach
                    @foreach ($postCategories as $key => $category)
                        @if ($category->children->count())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ route('post', $category->slug) }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $category->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($category->children as $categoryLevel2)
                                        <li><a class="dropdown-item" href="{{ route('post', $categoryLevel2->slug) }}">{{  $categoryLevel2->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ !$key ? 'active' : '' }}" aria-current="page" href="#">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- <li class="nav-item ms-0 ms-lg-3 py-2 py-lg-0">
                        <a href="{{ route('contact') }}" class="btn btn-danger rounded-pill">ĐĂNG KÝ NGAY</a>
                    </li>
                    <li class="nav-item d-block d-lg-none py-2 py-lg-0">
                        <a href="{{ setting('social.facebook') }}" target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="{{ setting('social.instagram') }}" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="{{ setting('social.tiktok') }}" target="_blank">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="{{ setting('social.youtube') }}" target="_blank">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="{{ setting('social.zalo') }}" target="_blank">
                            <span class="icon-zalo">Zalo</span>
                        </a>
                    </li> --}}
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item py-2 py-lg-0">
                        <a href="{{ route('contact') }}" class="btn btn-danger rounded-pill">ĐĂNG KÝ NGAY</a>
                    </li>
                    <li class="nav-item d-block d-lg-none py-2 py-lg-0">
                        <a href="{{ setting('social.facebook') }}" target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="{{ setting('social.instagram') }}" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="{{ setting('social.tiktok') }}" target="_blank">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="{{ setting('social.youtube') }}" target="_blank">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="{{ setting('social.zalo') }}" target="_blank">
                            <span class="icon-zalo">Zalo</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

@push('scripts')
<!-- <script>
    var header = document.querySelector(".header");
    function checkScroll() { 
        if (window.scrollY > 50) { 
            console.log(header)
            header.classList.add("sticky-top"); 
        } else { 
            header.classList.remove("sticky-top"); 
        }
    }
    window.addEventListener("scroll", checkScroll);
</script> -->
@endpush
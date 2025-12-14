<nav class="colorlib-nav" role="navigation">
    <div class="top-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="colorlib-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset(setting('web.logo')) }}" alt="" height="60" class="w-100">
                        </a>
                    </div>
                    <div class="mb-2 nav-cart-mobile text-center d-none">
                        <a href="{{ route('home') }}" class="float-left"><h6>{{ setting('web.name') }}</h6></a>
                        <a href="{{ route('cart') }}" class="d-inline-flex mr-4 position-relative">
                            <i class="icon icon-shopping-cart"></i>
                            <span class="cart-count">{{ Cart::count() }}</span>
                        </a>
                        @if(Auth::guard('user')->check())
                            <a href="{{ route('user.profile') }}" class="d-inline-flex"><i class="icon icon-user2 mr-2"></i> {{ auth()->guard('customer')->user()->name; }}</a>
                        @else 
                        <a href="{{ route('user.login') }}" class="d-inline-flex"><i class="icon icon-user2"></i></a>
                        @endif 
                    </div>
                </div>
                <div class="col-md-6 align-items-center d-flex">
                    <form action="{{ route('search') }}" class="search-wrap w-100" method="GET">
                        <div class="form-group mb-0">                        
                            <input class="form-control search" name="keyword" placeholder="Tìm kiếm sản phẩm" autocomplete="off" spellcheck="false">
                            <button class="btn btn-primary submit-search text-center" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 d-flex align-items-center nav-cart-desk">
                    <a href="{{ route('cart') }}" class="d-inline-flex ml-3 position-relative">
                        <i class="icon icon-shopping-cart"></i>
                        <span class="cart-count">{{ Cart::count() }}</span>
                    </a>
                    @if(Auth::guard('user')->check())
                        <a href="{{ route('user.profile') }}" class="d-inline-flex ml-4"><i class="icon icon-user2 mr-2"></i> {{ auth()->guard('customer')->user()->name; }}</a>
                    @else 
                    <a href="{{ route('user.login') }}" class="d-inline-flex ml-4"><i class="icon icon-user2"></i></a>
                    @endif 
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center menu-1">
                    <ul>
                        @foreach($categories as $category)
                            <li><a href="{{ route('product', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if ($campaigns->count())
    <div class="sale">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 text-center">
                    <div class="row">
                        <div class="owl-carousel2">
                            @foreach($campaigns as $campaign)
                                <div class="item">
                                    <div class="col">
                                        <h3><a href="{{ route('campaign.detail', $campaign->slug) }}">{{ $campaign->name }}</a></h3>
                                    </div>
                                </div>
                           @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</nav>
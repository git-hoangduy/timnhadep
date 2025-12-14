<footer id="colorlib-footer" role="contentinfo">
    <div class="container">
        <div class="row row-pb-md">
            <div class="col footer-col colorlib-widget">
                <h4>{{ setting('web.name') }}</h4>
                <p>{{ setting('web.meta_description') }}</p>
                <p>
                    <ul class="colorlib-social-icons">
                        @if(setting('web.facebook') != '')
                            <li>
                                <a href="{{ setting('web.facebook') }}" target="_blank">
                                    <img src="{{ asset('website/images/facebook.png') }}" alt="Facebook" width="30">
                                </a>
                            </li>
                        @endif
                        @if(setting('web.tiktok') != '')
                            <li>
                                <a href="{{ setting('web.tiktok') }}" target="_blank">
                                    <img src="{{ asset('website/images/tiktok.png') }}" alt="Tiktok" width="30">
                                </a>
                            </li>
                        @endif
                        @if(setting('web.youtube') != '')
                            <li>
                                <a href="{{ setting('web.youtube') }}" target="_blank">
                                    <img src="{{ asset('website/images/youtube.png') }}" alt="Youtube" width="30">
                                </a>
                            </li>
                        @endif
                        @if(setting('web.instagram') != '')
                            <li>
                                <a href="{{ setting('web.instagram') }}" target="_blank">
                                    <img src="{{ asset('website/images/instagram.png') }}" alt="Instagram" width="30">
                                </a>
                            </li>
                        @endif
                        @if(setting('web.twitter') != '')
                            <li>
                                <a href="{{ setting('web.twitter') }}" target="_blank">
                                    <img src="{{ asset('website/images/twitter.png') }}" alt="Twitter" width="30">
                                </a>
                            </li>
                        @endif
                    </ul>
                </p>
            </div>
            <div class="col footer-col colorlib-widget">
                <h4>Chính sách</h4>
                <p>
                    @if ($pages->count())
                    <ul class="colorlib-footer-links">
                        @foreach($pages as $page)
                            <li><a href="{{ route('page', $page->slug) }}">{{ $page->name }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </p>
            </div>
            <div class="col footer-col colorlib-widget">
                <h4>Thông tin</h4>
                <p>
                    <ul class="colorlib-footer-links">
                        <!-- <li><a href="{{ route('about') }}">Giới thiệu</a></li> -->
                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                    </ul>
                </p>
            </div>

            <div class="col footer-col">
                <h4>Danh mục</h4>
                <ul class="colorlib-footer-links">
                    @foreach($categories as $category)
                        <li><a href="{{ route('product', $category->slug) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col footer-col">
                <h4>Liên hệ</h4>
                <ul class="colorlib-footer-links">
                    <li>{{ setting('web.address') }}</li>
                    <li><a href="tel://{{ setting('web.hotline') }}">{{ setting('web.hotline') }}</a></li>
                    <li><a href="mailto:{{ setting('web.email') }}">{{ setting('web.email') }}</a></li>
                    <li><a href="{{ route('home') }}">{{ request()->getHost() }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copy">
        <div class="row">
            <div class="col-sm-12 text-center">
                <p>
                    <span>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</span> 
                </p>
            </div>
        </div>
    </div>
</footer>
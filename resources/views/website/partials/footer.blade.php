{{-- Contact form any page --}}
@include('website.partials.form-contact')

<!-- Back to Top Button -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</a>

<!-- Footer -->
<footer class="footer" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5>{{ setting('info.name') }}</h5>
                <p class="mb-4">{{ setting('info.description') }}</p>
                <div class="social-links">
                    <a href="{{ setting('social.facebook') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ setting('social.tiktok') }}" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="{{ setting('social.instagram') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="{{ setting('social.youtube') }}" target="_blank"><i class="fab fa-youtube"></i></a>
                    <!-- <a href="#"><i class="fab fa-linkedin-in"></i></a> -->
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h5>Liên kết</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li><a href="{{ route('project') }}">Dự án</a></li>
                    <li><a href="{{ route('listing') }}">Mua bán</a></li>
                    <li><a href="{{ route('post') }}">Tin tức</a></li>
                    <li><a href="{{ route('page', $pages->filter(function ($item) { return $item->id == 1; })->first()->slug) }}">Về chúng tôi</a></li>
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
                    <li><i class="fas fa-map-marker-alt me-2"></i> {{ setting('info.address') }}</li>
                    <li><i class="fas fa-phone me-2"></i> {{ setting('info.hotline') }}</li>
                    <li><i class="fas fa-envelope me-2"></i> {{ setting('info.email') }}</li>
                    <li><i class="fas fa-clock me-2"></i> {{ setting('info.time') }}</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="copyright">
                    <p>{{ setting('info.copyright') }} | <a href="{{ route('page', $pages->filter(function ($item) { return $item->id == 2; })->first()->slug) }}" class="text-white-50">Chính sách bảo mật</a> | <a href="{{ route('page', $pages->filter(function ($item) { return $item->id == 3; })->first()->slug) }}" class="text-white-50">Điều khoản sử dụng</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
@push('scripts')
<script>

</script>
@endpush
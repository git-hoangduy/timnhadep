{{-- Contact form any page --}}
@include('website.partials.form-contact')

{{-- Footer --}}
<div class="footer">
    <div class="container">
        <div class="footer-logo"></div>
        <div class="row">
            @foreach($footers as $footer)
                <div class="col-12 col-sm-6 col-md-3 mt-md-0 mt-sm-3 mt-3">
                    <h5 class="footer-name">{{ $footer->name }}</h5>
                    <div class="footer-content">{!! renderContent($footer->content) !!}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="footer-copyright">
    {{ setting('info.copyright') }}
</div>

{{-- Contact icon --}}
<div class="footer-icons">
    @if (setting('info.hotline') != '')
    <a href="{{ setting('info.hotline') }}" target="_blank">
        <div class="hotline">
            <i class="bi bi-telephone-fill"></i>
        </div>
    </a>
    @endif
    @if (setting('social.facebook') != '')
        <a href="{{ setting('social.facebook') }}" target="_blank" class="mt-2">
            <div class="messenger">
                <i class="bi bi-messenger"></i>
            </div>
        </a>
    @endif
    @if (setting('social.zalo') != '')
        <a href="https://zalo.me/{{ setting('social.zalo') }}" target="_blank" class="mt-2">
            <div class="zalo">
                <span>Zalo</span>
            </div>
        </a>
    @endif
</div>

{{-- Scroll to top --}}
<button onclick="topFunction()" id="scrollToTop" title="Lên đầu trang"><i class="bi bi-arrow-up"></i></button>

@push('scripts')
<script>

    let scrollToTop = document.getElementById("scrollToTop");

    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTop.style.display = "block";
        } else {
            scrollToTop.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    
</script>
@endpush
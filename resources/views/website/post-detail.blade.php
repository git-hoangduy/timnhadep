@extends('website.master')
@section('content')

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="index.html#news">Trang</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $post->name }}
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- News Detail -->
<section class="news-detail-page">
    <div class="container">
        <div class="news-header">
            <span class="news-category">{{ $post->category->name }}</span>
            <h1 class="news-title">{{ $post->name }}</h1>
            
            <!-- <div class="news-meta">
                <div class="news-meta-item">
                    <i class="far fa-calendar-alt"></i>
                    <span>15/10/2023</span>
                </div>
                <div class="news-meta-item">
                    <i class="far fa-user"></i>
                    <span>Nguyễn Văn A</span>
                </div>
                <div class="news-meta-item">
                    <i class="far fa-clock"></i>
                    <span>5 phút đọc</span>
                </div>
                <div class="news-meta-item">
                    <i class="far fa-eye"></i>
                    <span>1,245 lượt xem</span>
                </div> -->
            </div>
        </div>

        <div class="news-featured-image">
            <img src="{{ asset($post->image) }}" alt="{{ $post->name }}">
        </div>

        <div class="news-content">

            {!! renderContent($post->content) !!}

            <div class="news-tags">
                <a href="#" class="news-tag">Bất động sản 2023</a>
                <a href="#" class="news-tag">Đầu tư bất động sản</a>
                <a href="#" class="news-tag">Thị trường nhà đất</a>
                <a href="#" class="news-tag">Xu hướng đầu tư</a>
                <a href="#" class="news-tag">Phân tích thị trường</a>
            </div>

            {{-- <div class="news-author">
                <div class="author-avatar">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Nguyễn Văn A">
                </div>
                <div class="author-info">
                    <h4>Nguyễn Văn A</h4>
                    <p>Chuyên gia phân tích thị trường bất động sản với hơn 10 năm kinh nghiệm. Ông đã tư vấn cho nhiều dự án lớn tại Việt Nam và có nhiều bài viết chuyên sâu về thị trường bất động sản.</p>
                </div>
            </div> --}}
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>

</script>
@endpush
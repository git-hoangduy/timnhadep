@extends('website.master')
@section('content')

@push('styles')
<style>
    /* Main content */
    .news-detail-page {
        padding: 60px 0;
        background-color: #fff;
    }

    .news-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .news-category {
        display: inline-block;
        background: var(--primary-color);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .news-title {
        font-size: 36px;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .news-meta {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        color: var(--gray-color);
        font-size: 15px;
        margin-bottom: 30px;
    }

    .news-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .news-meta-item i {
        color: var(--primary-color);
    }

    .news-featured-image {
        margin-bottom: 40px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .news-featured-image img {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }

    .news-content {
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.8;
        font-size: 16px;
        color: #444;
    }

    .news-content h2 {
        font-size: 28px;
        color: var(--dark-color);
        margin: 40px 0 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-light);
    }

    .news-content h3 {
        font-size: 22px;
        color: var(--dark-color);
        margin: 30px 0 15px;
    }

    .news-content p {
        margin-bottom: 20px;
    }

    .news-content ul, .news-content ol {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .news-content li {
        margin-bottom: 10px;
    }

    .news-content blockquote {
        border-left: 4px solid var(--primary-color);
        padding-left: 20px;
        margin: 30px 0;
        font-style: italic;
        color: var(--gray-color);
        font-size: 18px;
    }

    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 30px 0;
    }

    .news-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 40px 0;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .news-tag {
        background: rgba(235, 93, 30, 0.1);
        color: var(--primary-color);
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        transition: var(--transition);
    }

    .news-tag:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .news-author {
        background: #f9f9f9;
        border-radius: 12px;
        padding: 30px;
        margin: 40px 0;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .author-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
    }

    .author-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-info h4 {
        margin-bottom: 10px;
        color: var(--dark-color);
    }

    .author-info p {
        color: var(--gray-color);
        margin-bottom: 0;
    }

    /* Related news */
    .related-news {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .section-title {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 40px;
        text-align: center;
        color: var(--dark-color);
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .related-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        height: 100%;
    }

    .related-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .related-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .related-card-body {
        padding: 20px;
    }

    .related-card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--dark-color);
        line-height: 1.4;
    }

    .related-card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        font-size: 14px;
        color: var(--gray-color);
    }

    .related-card-category {
        background: rgba(235, 93, 30, 0.1);
        color: var(--primary-color);
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }

    .related-card-excerpt {
        color: var(--gray-color);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .news-title {
            font-size: 32px;
        }
        
        .news-featured-image img {
            height: 400px;
        }
    }

    @media (max-width: 768px) {
        .news-detail-page {
            padding: 40px 0;
        }
        
        .news-title {
            font-size: 28px;
        }
        
        .news-meta {
            flex-direction: column;
            gap: 15px;
        }
        
        .news-featured-image img {
            height: 300px;
        }
        
        .news-content {
            font-size: 15px;
        }
        
        .news-content h2 {
            font-size: 24px;
        }
        
        .news-content h3 {
            font-size: 20px;
        }
        
        .news-author {
            flex-direction: column;
            text-align: center;
        }
        
        .author-avatar {
            width: 80px;
            height: 80px;
        }
    }

    @media (max-width: 576px) {
        .news-title {
            font-size: 24px;
        }
        
        .news-featured-image img {
            height: 250px;
        }
        
        .section-title {
            font-size: 28px;
        }
    }
</style>
@endpush

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $page->name }}
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- News Detail -->
<section class="news-detail-page">
    <div class="container">
        <div class="news-header">
            <span class="news-category">{{ $page->category->name ?? '' }}</span>
            <h1 class="news-title">{{ $page->name }}</h1>
            
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
            @if ($page->images->count())
                @foreach($page->images as $image)
                    <img src="{{ asset($image->image) }}" alt="{{ $page->name }}">
                @endforeach
            @endif
        </div>

        <div class="news-content">
            @foreach($page->blocks as $key => $block)
                <div class="page-block-image" style="background-image: url({{ asset($block->block_image) }})">
                    <div class="container">
                        <div class="page-block py-5">
                            {!! renderContent($block->block_content) !!}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>

</script>
    
@endpush
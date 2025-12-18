@extends('website.master')
@section('content')

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
                <li class="breadcrumb-item active" aria-current="page">
                    Tin tức
                </li>
            </ol>
        </nav>
    </div>
</section>
<div class="projects-section" id="posts">
        <div class="container">
            <p class="text-center text-muted mb-5 d-none">Cập nhật tin tức mới nhất về thị trường bất động sản, chính sách và xu hướng đầu tư</p>
            
            <div class="row">
                @foreach($posts as $key => $item)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card animate-on-scroll">
                        <div class="news-img">
                            <img src="{{ asset($item->image) }}" alt="Thị trường bất động sản 2023">
                            <div class="news-category">{{ $item->category->name }}</div>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-date"><i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('d/m/Y') }}</span>
                                <span class="news-author"><i class="far fa-user me-1"></i> Tìm nhà đẹp</span>
                            </div>
                            <h3 class="news-title">{{ $item->name }}</h3>
                            <p class="news-excerpt">{{ $item->excerpt }}</p>
                            <a href="{{route('post.detail', ['slug' => $item->slug])}}" class="news-link">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
@extends('website.master')

@section('content')

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
                    Mua bán
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Listing Section -->
<section class="projects-section" id="listings">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 class="section-title">Tin đăng mua bán</h2>
                <p class="text-muted">Khám phá hàng nghìn tin đăng mua bán bất động sản từ cộng đồng</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">
                    <i class="fas fa-plus-circle me-2"></i>Đăng tin mới
                </button>
            </div>
        </div>
        
        <!-- Listing Grid -->
        <div class="row">
            @if($listings->count() > 0)
                @foreach($listings as $listing)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="listing-card animate-on-scroll">
                        <div class="listing-img">
                            <img src="{{ asset($listing->avatar_image) }}" alt="{{ $listing->name }}">
                            <div class="listing-type">{{ $listing->category?->name }}</div>
                        </div>
                        <div class="listing-content">
                            <div class="listing-meta">
                                <span class="listing-date">
                                    <i class="far fa-calendar-alt me-1"></i> 
                                    {{ $listing->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="listing-title">{{ $listing->name }}</h3>
                            <p class="listing-excerpt">{{ $listing->excerpt }}</p>
                            
                            <div class="listing-footer">
                                <div class="listing-price">{{ $listing->formatted_price }}</div>
                                <div class="listing-location">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    {{ Str::limit($listing->location, 25) }}
                                </div>
                            </div>
                            
                            <a href="{{ route('listing.detail', ['slug' => $listing->slug]) }}" 
                               class="btn btn-outline-primary w-100 mt-3">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-home fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Không có tin đăng nào</h4>
                        <p>Hãy là người đầu tiên đăng tin tại đây!</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">
                            <i class="fas fa-plus-circle me-2"></i>Đăng tin ngay
                        </button>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($listings->count() > 0)
        <div class="text-center mt-5">
            {{ $listings->links() }}
        </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
/* Additional styles for listing page */
.listing-card {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    height: 100%;
    margin-bottom: 30px;
}

.listing-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-hover);
}

.listing-img {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.listing-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.listing-card:hover .listing-img img {
    transform: scale(1.08);
}

.listing-type {
    position: absolute;
    top: 15px;
    left: 15px;
    background-color: var(--primary-color);
    color: white;
    padding: 5px 15px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}

.listing-content {
    padding: 25px;
}

.listing-meta {
    margin-bottom: 15px;
    font-size: 0.85rem;
    color: var(--gray-color);
}

.listing-date {
    display: flex;
    align-items: center;
}

.listing-title {
    font-size: 1.25rem;
    margin-bottom: 15px;
    min-height: 3.6rem;
    line-height: 1.4;
    color: var(--dark-color);
}

.listing-excerpt {
    color: var(--gray-color);
    margin-bottom: 20px;
    min-height: 4.2rem;
    line-height: 1.6;
    font-size: 0.95rem;
}

.listing-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.listing-price {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.3rem;
}

.listing-location {
    color: var(--gray-color);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
}

@media (max-width: 768px) {
    .listing-title {
        font-size: 1.1rem;
        min-height: auto;
    }
    
    .listing-excerpt {
        min-height: auto;
    }
    
    .listing-img {
        height: 180px;
    }
}
</style>
@endpush
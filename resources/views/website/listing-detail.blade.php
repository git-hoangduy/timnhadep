@extends('website.master')

@section('content')

<style>
    .mark-phone {
        cursor: pointer;
    }
</style>
@php
    $phone = $listing->customer_id != '' ? $listing->customer_phone : setting('info.phone');
    $email = $listing->customer_id != '' ? $listing->customer_email : setting('info.email');
    $markPhone = '';
    if (strlen($phone) >= 5) {
        $markPhone = substr($phone, 0, 3) . '****' . substr($phone, -2);
    }


    $customerId = '';
    $customerPhone = '';
    $customerName = '';
    if (auth()->guard('customer')->check()) {
        $customerId = auth()->guard('customer')->user()->id;
        $customerPhone = auth()->guard('customer')->user()->phone ? auth()->guard('customer')->user()->phone : '';
        $customerName = auth()->guard('customer')->user()->name ? auth()->guard('customer')->user()->name : '';
    }
@endphp
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
                <li class="breadcrumb-item">
                    <a href="{{ route('listing') }}">
                        {{ $listing->type_text }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $listing->name }}
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Listing Detail -->
<section class="listing-detail-page">
    <div class="container">
        @if ($listing->status == 0)
            <div class="alert alert-warning text-center" role="alert">
                Tin đăng này hiện đang chờ duyệt. Vui lòng quay lại sau!
            </div>
        @else
        <div class="row">

            <!-- Left Column -->
            <div class="col-lg-8">

                <!-- Images -->
                <div class="listing-images">
                    <div class="main-image">
                        <img id="mainImage"
                             src="{{ asset($listing->avatar_image) }}"
                             alt="{{ $listing->name }}">
                    </div>

                    <div class="thumbnail-images">
                        @foreach($listing->images as $key => $img)
                            <div class="thumbnail {{ $key === 0 ? 'active' : '' }}"
                                 onclick="changeImage(this)">
                                <img src="{{ asset($img->image) }}" alt="{{ $listing->name }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Listing Info -->
                <div class="listing-info">
                    <h1 class="listing-title">
                        {{ $listing->name }}
                    </h1>

                    <div class="listing-meta">
                        <div class="listing-price">
                            {{ $listing->formatted_price }}
                        </div>

                        <span class="listing-type">
                            {{ $listing->category?->name }}
                        </span>

                        <span class="listing-date">
                            <i class="far fa-clock me-1"></i>
                            Đăng: {{ $listing->created_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="listing-description">
                        <h3 class="description-title">Mô tả chi tiết</h3>
                        <div class="description-content">
                            {!! $listing->content !!}
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="listing-location">
                        <h3 class="location-title">Vị trí</h3>
                        <div class="location-details">
                            <p>
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <strong>Địa chỉ:</strong>
                                {{ $listing->province->name.', '.$listing->ward->name.', ' }}  {{ $listing->location }}
                            </p>
                        </div>

                        <div class="map-container d-none">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt fa-3x mb-3" style="color: #6c757d;"></i>
                                <p>Bản đồ vị trí</p>
                                <small>(Bản đồ sẽ hiển thị tại đây)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <div class="seller-info sticky-top" style="top:100px">

                    <div class="seller-header">
                        <div class="seller-avatar">
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                 alt="{{ $listing->customer_name ?? 'Tìm nhà đẹp' }}">
                        </div>
                        <div class="seller-details">
                            <h4>{{ $listing->customer_name ?? 'Tìm nhà đẹp' }}</h4>
                            <small class="text-muted">
                                Thành viên từ {{ $listing->created_at->format('Y') }}
                            </small>
                        </div>
                    </div>

                    <div class="contact-actions">
                        <a href="tel:{{ $markPhone }}"
                           class="btn btn-primary mark-phone">
                            <i class="fas fa-phone-alt me-2"></i>
                            Gọi ngay: {{ $markPhone }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <h5 class="mb-3">Thông tin liên hệ</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <span class="mark-phone">{{ $markPhone }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                {{ $email }}
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
    function changeImage(el) {
        const img = el.querySelector('img');
        document.getElementById('mainImage').src = img.src;

        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    $('.mark-phone').on('click', function(e) {
        e.preventDefault();

        if (localStorage.getItem('viewed_listing_{{ $listing->id }}') == 'true') {
            const fullPhone = '{{ $phone }}';
            $('.mark-phone').text(fullPhone);
            window.location.href = 'tel:' + fullPhone;
            return;
        }

        let customerPhone = '{{ $customerPhone }}';
        let customerName = '{{ $customerName }}';
        let customerId = '{{ $customerId }}';

        // call ajax get full phone number by listing id
        $.ajax({
            url: '{{ route("listing.get-full-phone") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                listing_id: '{{ $listing->id }}',
                customer_id: customerId,
                customer_phone: customerPhone,
                customer_name: customerName
            },
            success: function(response) {
                if (response.success) {
                    localStorage.setItem('viewed_listing_{{ $listing->id }}', 'true');
                    const fullPhone = response.phone;
                    $('.mark-phone').text(fullPhone);
                    window.location.href = 'tel:' + fullPhone;
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
            }
        });

    });

    $(document).ready(function() {
        if (localStorage.getItem('viewed_listing_{{ $listing->id }}') == 'true') {
            const fullPhone = '{{ $phone }}';
            $('.mark-phone').text(fullPhone);
        }
    });
</script>
@endpush

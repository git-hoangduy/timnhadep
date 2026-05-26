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
                    {{-- <p class="text-muted">Khám phá hàng nghìn tin đăng mua bán bất động sản từ cộng đồng</p> --}}
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">
                        <i class="fas fa-plus-circle me-2"></i>Đăng tin mới
                    </button>
                </div>
            </div>

            <!-- Bộ lọc tìm kiếm -->
            <div class="filter-section mb-5">
                <form action="{{ route('listing') }}" method="GET" class="filter-form">
                    <div class="card border">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Tỉnh/Thành phố -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold mb-2">Tỉnh/Thành phố</label>
                                        <select name="province_code" class="form-select form-select-sm" id="filter_province">
                                            <option value="">Tất cả tỉnh/thành</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->code }}"
                                                    {{ request('province_code') == $province->code ? 'selected' : '' }}>
                                                    {{ $province->type }} {{ $province->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold mb-2">Phường/Xã</label>
                                        <select name="ward_code" class="form-select form-select-sm" id="filter_ward">
                                            <option value="">Tất cả phường/xã</option>
                                            @if (request('province_code'))
                                                @php
                                                    $wards = \App\Models\Ward::where(
                                                        'province_code',
                                                        request('province_code'),
                                                    )
                                                        ->orderBy('name', 'asc')
                                                        ->get();
                                                @endphp
                                                @foreach ($wards as $ward)
                                                    <option value="{{ $ward->code }}"
                                                        {{ request('ward_code') == $ward->code ? 'selected' : '' }}>
                                                        {{ $ward->type }} {{ $ward->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Loại BĐS -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold mb-2">Loại BĐS</label>
                                        <select name="category" class="form-select form-select-sm">
                                            <option value="">Tất cả loại</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold mb-2">Hình thức</label>
                                        <select name="type" class="form-select form-select-sm">
                                            <option value="">Tất cả</option>
                                            <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Cần bán
                                            </option>
                                            <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>Cho thuê
                                            </option>
                                            {{-- <option value="buy" {{ request('type') == 'buy' ? 'selected' : '' }}>Cần mua</option> --}}
                                            {{-- <option value="rental" {{ request('type') == 'rental' ? 'selected' : '' }}>Cần thuê</option> --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Lọc theo giá bán
                                    </label>
                                    <span id="priceValue" class="">
                                        @if (request('min_price') && request('max_price'))
                                            {{ number_format(request('min_price')) }} -
                                            {{ number_format(request('max_price')) }}
                                        @elseif(request('min_price'))
                                            Giá Từ {{ number_format(request('min_price')) }}
                                        @elseif(request('max_price'))
                                            Đến {{ number_format(request('max_price')) }}
                                        @else
                                            Tất cả
                                        @endif
                                    </span>

                                    <!-- Hidden inputs for min and max price -->
                                    <input type="hidden" name="min_price" id="min_price"
                                        value="{{ request('min_price') }}">
                                    <input type="hidden" name="max_price" id="max_price"
                                        value="{{ request('max_price') }}">

                                    <div class="price-slider-container">
                                        <div id="priceRangeSlider"></div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small id="minPriceLabel">Giá thấp nhất 0</small>
                                            <small id="maxPriceLabel">Giá cao nhất {{ number_format($maxPriceRange) }}</small>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 mt-2">
                                        <input type="number" class="form-control form-control-sm" id="min_price_input"
                                            placeholder="Từ" min="0" max="{{ $maxPriceRange }}">
                                        <input type="number" class="form-control form-control-sm" id="max_price_input"
                                            placeholder="Đến" min="0" max="{{ $maxPriceRange }}">
                                    </div>
                                </div>

                                <!-- Nút tìm kiếm -->
                                <div class="col-md-12 mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                                <i class="fas fa-search me-2"></i>Tìm kiếm
                                            </button>
                                            @if (request()->has('province_code') ||
                                                    request()->has('ward_code') ||
                                                    request()->has('category') ||
                                                    request()->has('type') ||
                                                    request()->has('price'))
                                                <a href="{{ route('listing') }}"
                                                    class="btn btn-outline-secondary btn-sm ms-2">
                                                    <i class="fas fa-times me-2"></i>Xóa lọc
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Listing Grid -->
            <div class="row">
                @if ($listings->count() > 0)
                    @foreach ($listings as $listing)
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
                                    <p class="listing-excerpt">{!! nl2br(htmlspecialchars_decode($listing->excerpt)) !!}</p>

                                    <div class="listing-footer">
                                        <div class="listing-price">{{ $listing->formatted_price }}</div>
                                        <div class="listing-location">
                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                            {{-- {{ Str::limit($listing->location, 25) }} --}}
                                            @if ($listing->province)
                                                {{$listing->province->name }}
                                                @if ($listing->ward?->name)
                                                    , {{$listing->ward?->name }}
                                                @endif
                                            @else
                                                {{ Str::limit($listing->location, 25) }}
                                            @endif
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
            @if ($listings->count() > 0)
                <div class="text-center mt-5">
                    {{ $listings->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection

@push('styles')
    <style>
        /* Price range slider styles */
        .price-slider-container {
            padding: 0 10px;
            margin-top: 10px;
            margin-bottom: 27px;
        }

        #priceRangeSlider {
            height: 6px;
            margin-top: 10px;
        }

        .noUi-connect {
            background: var(--primary-color);
        }

        .noUi-handle {
            height: 18px !important;
            width: 18px !important;
            top: -7px !important;
            right: -9px  !important;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--primary-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .noUi-handle:before,
        .noUi-handle:after {
            display: none;
        }

        .noUi-handle:hover {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .noUi-tooltip {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 11px;
        }

        .noUi-tooltip:before {
            content: '';
            position: absolute;
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid var(--primary-color);
        }

        #priceValue {
            display: block;
            font-weight: normal;
            color: var(--primary-color);
            margin-top: 5px;
            font-size: 12px;
            font-weight: 600
        }

        #minPriceLabel,
        #maxPriceLabel {
            color: #6c757d;
            font-size: 11px;
            font-weight: 600;
        }

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
            height: 90px;
            overflow: hidden;
            position: relative;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .listing-excerpt::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(to bottom, transparent, white);
            pointer-events: none;
        }

        .listing-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* margin-bottom: 15px; */
        }

        .listing-price {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 1.2rem;
        }

        .listing-location {
            color: var(--gray-color);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            margin-bottom: 0;
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

@push('scripts')
    <script>
        // Initialize price range slider
        let minPrice = {{ request('min_price', 0) }};
        let maxPrice = {{ request('max_price', $maxPriceRange) }};
        let maxPriceRange = {{ $maxPriceRange }};

        // Initialize slider
        let priceSlider = document.getElementById('priceRangeSlider');
        noUiSlider.create(priceSlider, {
            start: [minPrice, maxPrice],
            connect: true,
            range: {
                'min': 0,
                'max': maxPriceRange
            },
            step: Math.ceil(maxPriceRange / 50), // Tự động tính bước nhảy
            format: {
                to: function(value) {
                    return Math.round(value);
                },
                from: function(value) {
                    return Number(value);
                }
            }
        });

        // Update hidden inputs when slider changes
        priceSlider.noUiSlider.on('update', function(values) {
            let minVal = Math.round(values[0]);
            let maxVal = Math.round(values[1]);

            $('#min_price').val(minVal);
            $('#max_price').val(maxVal);
            $('#min_price_input').val(minVal);
            $('#max_price_input').val(maxVal);

            // Update display text
            if (minVal == 0 && maxVal == maxPriceRange) {
                $('#priceValue').text('Tất cả');
            } else if (minVal == 0) {
                $('#priceValue').text(`Đến ${formatNumber(maxVal)}đ`);
            } else if (maxVal == maxPriceRange) {
                $('#priceValue').text(`Giá Từ ${formatNumber(minVal)}đ`);
            } else {
                $('#priceValue').text(`${formatNumber(minVal)}đ - ${formatNumber(maxVal)}đ`);
            }
        });

        // Update slider when manual input changes
        $('#min_price_input').on('change', function() {
            let minVal = parseInt($(this).val()) || 0;
            let maxVal = parseInt($('#max_price_input').val()) || maxPriceRange;

            if (minVal < 0) minVal = 0;
            if (minVal > maxVal) minVal = maxVal;

            priceSlider.noUiSlider.set([minVal, null]);
        });

        $('#max_price_input').on('change', function() {
            let maxVal = parseInt($(this).val()) || maxPriceRange;
            let minVal = parseInt($('#min_price_input').val()) || 0;

            if (maxVal > maxPriceRange) maxVal = maxPriceRange;
            if (maxVal < minVal) maxVal = minVal;

            priceSlider.noUiSlider.set([null, maxVal]);
        });

        // Number formatting function
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Set initial values for input boxes
        $('#min_price_input').val(minPrice);
        $('#max_price_input').val(maxPrice);

        // Update labels
        $('#maxPriceLabel').text('Giá cao nhất ' + formatNumber(maxPriceRange));


        // Load phường/xã khi chọn tỉnh
        $('#filter_province').on('change', function() {
            let provinceCode = $(this).val();
            let wardSelect = $('#filter_ward');

            if (!provinceCode) {
                wardSelect.html('<option value="">Tất cả phường/xã</option>');
                return;
            }

            // Hiển thị loading
            wardSelect.html('<option value="">Đang tải...</option>');

            $.ajax({
                url: '{{ route('listing.get.wards') }}',
                type: 'GET',
                data: {
                    province_code: provinceCode
                },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let options = '<option value="">Tất cả phường/xã</option>';
                        $.each(response.data, function(index, ward) {
                            options +=
                                `<option value="${ward.code}">${ward.type} ${ward.name}</option>`;
                        });
                        wardSelect.html(options);
                    } else {
                        wardSelect.html('<option value="">Không có dữ liệu</option>');
                    }
                },
                error: function() {
                    wardSelect.html('<option value="">Lỗi tải dữ liệu</option>');
                }
            });
        });

        // Trigger change nếu đã chọn tỉnh khi load trang
        @if (request('province_code'))
            $(document).ready(function() {
                $('#filter_province').trigger('change');
            });
        @endif
    </script>
@endpush

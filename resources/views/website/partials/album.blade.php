@if($album->images->count())
<h3>Hình ảnh dự án</h3>

<div class="album gallery">

    {{-- Main image --}}
    <div class="gallery-main">
        <img
            src="{{ asset($album->images->first()->image) }}"
            alt="{{ $album->images->first()->name }}"
            class="img-fluid main-gallery-image">
    </div>

    {{-- Thumbnails --}}
    <div class="gallery-thumbnails">
        @foreach($album->images as $index => $image)
            <div
                class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                data-image="{{ asset($image->image) }}">
                
                <img
                    src="{{ asset($image->image) }}"
                    alt="{{ $image->name }}">

                <div class="thumbnail-overlay">
                    <!-- <span>{{ $image->name }}</span> -->
                </div>
            </div>
        @endforeach
    </div>

    {{-- Navigation --}}
    <div class="gallery-nav">
        <button class="gallery-prev">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="gallery-counter">
            <span class="currentImage">1</span> /
            <span class="totalImages">{{ $album->images->count() }}</span>
        </div>

        <button class="gallery-next">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

</div>
@endif

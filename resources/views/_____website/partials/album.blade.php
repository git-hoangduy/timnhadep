<div class="album">
    <div class="album-slide">
        @foreach($album->images as $image)
            <div class="album-slide-item">
                <img src="{{ asset($image->image) }}" alt="{{ $image->name }}">
            </div>
        @endforeach
    </div>
    <div class="album-nav">
        @foreach($album->images as $image)
            <div class="album-nav-item">
                <img src="{{ asset($image->image) }}" alt="{{ $image->name }}">
            </div>
        @endforeach
    </div>
</div>
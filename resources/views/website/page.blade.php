@extends('website.master')
@section('content')

<div class="main">
    
    @if ($page->images->count())
        <div class="page-banner">
            <div class="main-carousel">
                @foreach($page->images as $image)
                    <div class="carousel-cell">
                        <img src="{{ asset($image->image) }}" alt="">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

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

@endsection

@push('scripts')
<script>
    $('.main-carousel').flickity({
        cellAlign: 'left',
        contain: true
    });
</script>
    
@endpush
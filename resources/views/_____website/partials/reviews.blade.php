@if ($reviews->count())
    <div class="review-container">
        <div class="review-carousel">
            @foreach($reviews as $item)
                <div class="container">
                    <div class="row justify-content-center review-carousel-cell">
                        <div class="col-12 col-md-2">
                            <img src="{{ asset($item->image) }}" alt="">
                        </div>
                        <div class="col-12 col-md-8 pt-3">
                            {!! $item->content !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@php

    $posts = App\Models\Post::where('status', 1)->orderBy('is_highlight', 'desc')->orderBy('id', 'desc')->limit(5) ->get();

@endphp
<div class="post-category-content">
    <div class="post-category-title">
        <h4 class="pt-0">Tin tức và sự kiện</h4>
    </div>
    @if($posts->count())
    <div class="features-post-list">
        <div class="row">
            <div class="col-md-6 col-left">
                <div class="card post-item">
                    <a href="{{ route('post.detail', $posts->first()->slug) }}" class="post-image">
                        <img src="{{ asset($posts->first()->image ?? '') }}" class="card-img-top" alt="{{ $posts->first()->name }}">
                    </a>
                    <div class="card-body">
                        <p class="post-category">{{ $posts->first()->category->name }}</p>
                        <a href="{{ route('post.detail', $posts->first()->slug) }}">
                            <h2 class="post-title">{{ $posts->first()->name }}</h2>
                        </a>
                        <p class="card-text post-excerpt">{{ $posts->first()->excerpt }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-right">
                <div class="row">
                    @foreach($posts->skip(1)->take(4) as $key => $post)
                        <div class="col-md-6 mb-4">
                            <div class="card post-item">
                                <a href="{{ route('post.detail', $post->slug) }}" class="post-image">
                                    <img src="{{ asset($post->image ?? '') }}" class="card-img-top" alt="{{ $post->name }}">
                                </a>
                                <div class="card-body">
                                    <p class="post-category">{{ $post->category->name }}</p>
                                    <a href="{{ route('post.detail', $post->slug) }}">
                                        <h2 class="post-title-small">{{ $post->name }}</h2>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @else
        <h5 class="fw-bold text-center">Không có bài viết mới nào.</h5>
    @endif
</div>
@extends('website.master')
@section('content')

<div class="main">
	<div class="container">
		<div class="post-category-content">
            <div class="post-category-title">
                <h4>{{ $category ? $category->name : 'Tất cả bài viết' }}</h4>
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
                <div class="other-post-list-title">Các {{ $category->name }} khác</div>
                <div class="other-post-list">
                    @php
                        $take = 5;
                        $count = $posts->count();
                        $otherPosts = $posts->skip(5)->take($count - $take);
                    @endphp
                    @foreach($otherPosts as $post)
                        <div class="card mb-3 post-item">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ route('post.detail', $post->slug) }}" class="post-image">
                                        <img src="{{ asset($post->image ?? '') }}" class="img-fluid" alt="{{ $post->name }}">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body post-info">
                                        <div>
                                            <p class="post-category">{{ $post->category->name }}</p>
                                            <a href="{{ route('post.detail', $post->slug) }}">
                                                <h2 class="post-title-small">{{ $post->name }}</h2>
                                            </a>
                                            <p class="card-text post-excerpt">{{ $post->excerpt }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h5 class="fw-bold text-center mb-5">Không có bài viết mới nào.</h5>
            @endif
		</div>
	</div>
</div>

@endsection
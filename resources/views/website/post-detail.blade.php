@extends('website.master')
@section('content')

<div class="main pb-5">
	<div class="container">
		<div class="row mt-4 justify-content-center">
			<!-- <div class="col-md-3">
				<p class="mb-2">Ngày đăng: <b>{{ $post->created_at->format('d/m/Y') }}</b></p>
				<p class="mb-2">Người đăng: <b>Admin</b></p>
			</div> -->
			<div class="col-md-9">
				<div class="post-detail d-block">
					<div class="post-detail-title">
						<h4>{{ $post->name }}</h4>
					</div>
	                <div class="post-detail-content">
	                    <!-- <img src="{{ asset($post->image) }}" alt="{{ $post->name }}" class="w-100 mb-4"> -->
						<p class="post-detail-excerpt">{{ $post->excerpt }}</p>
						{!! renderContent($post->content) !!}
					</div>
					<p class="mt-5 pe-2 text-end">Người đăng: <b>Admin</b></p>
				</div>
			</div>
		</div>

		@if ($recentPosts->count())
			<div class="recent-posts-title">
				<h4>Bài viết khác</h4>
			</div>
			<div class="recent-posts">
				@foreach($recentPosts as $post)
					<div class="col-md-3 mb-4 px-2">
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
		@endif
	</div>
</div>

@endsection

@push('scripts')
<script>

	if ($('.recent-posts').length > 0) {
		$('.recent-posts').flickity({
			cellAlign: 'left',
			contain: true,
			pageDots: false,
			prevNextButtons: true
		});
	}
</script>
@endpush
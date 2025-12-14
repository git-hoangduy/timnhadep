<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		{!! SEOMeta::generate() !!}
    	{!! OpenGraph::generate() !!}
		<link rel="icon" type="image/x-icon" href="{{ asset(setting('web.shortcut')) }}">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Rokkitt:100,300,400,700" rel="stylesheet">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<!-- Animate.css -->
		<link rel="stylesheet" href="{{ asset('website/css/animate.css') }}">
		<!-- Icomoon Icon Fonts-->
		<link rel="stylesheet" href="{{ asset('website/css/icomoon.css') }}">
		<!-- Bootstrap  -->
		<link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css') }}">
		<!-- Magnific Popup -->
		<link rel="stylesheet" href="{{ asset('website/css/magnific-popup.css') }}">
		<!-- Flexslider  -->
		<link rel="stylesheet" href="{{ asset('website/css/flexslider.css') }}">
		<!-- Owl Carousel -->
		<link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('website/css/owl.theme.default.min.css') }}">
		<!-- Date Picker -->
		<link rel="stylesheet" href="{{ asset('website/css/bootstrap-datepicker.css') }}">
		<!-- Theme style  -->
		<link rel="stylesheet" href="{{ mix('website/css/shop.min.css') }}">
	</head>
	<body>
		
	<div class="colorlib-loader"></div>

	<div id="page">
		@include('website.partials.header')
		@yield('content')
		@include('website.partials.footer')
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon icon-arrow-up3"></i></a>
	</div>
	
	<!-- jQuery -->
	<script src="{{ asset('website/js/jquery.min.js') }}"></script>
	<!-- popper -->
	<script src="{{ asset('website/js/popper.min.js') }}"></script>
	<!-- bootstrap 4.1 -->
	<script src="{{ asset('website/js/bootstrap.min.js') }}"></script>
	<!-- bootstrap autocomplate -->
	<script src="{{ asset('website/js/bootstrap-autocomplete.min.js') }}"></script>
	<!-- jQuery easing -->
	<script src="{{ asset('website/js/jquery.easing.1.3.js') }}"></script>
	<!-- Waypoints -->
	<script src="{{ asset('website/js/jquery.waypoints.min.js') }}"></script>
	<!-- Flexslider -->
	<script src="{{ asset('website/js/jquery.flexslider-min.js') }}"></script>
	<!-- Owl carousel -->
	<script src="{{ asset('website/js/owl.carousel.min.js') }}"></script>
	<!-- Magnific Popup -->
	<script src="{{ asset('website/js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('website/js/magnific-popup-options.js') }}"></script>
	<!-- Date Picker -->
	<script src="{{ asset('website/js/bootstrap-datepicker.js') }}"></script>
	<!-- Stellar Parallax -->
	<script src="{{ asset('website/js/jquery.stellar.min.js') }}"></script>
	<!-- Main -->
	<script src="{{ mix('website/js/shop.min.js') }}"></script>
	<!-- Custom script -->
	<script>
		var routes = {
			'fetchProducts': '{{ route("fetchProducts") }}',
			'searchProducts': '{{ route("searchProducts") }}',
			'cartAdd': '{{ route("cart.add") }}',
			'cartUpdate': '{{ route("cart.update") }}',
			'cartRemove': '{{ route("cart.remove") }}',
			'couponApply': '{{ route("coupon.apply") }}',
			'reviewAdd': '{{ route("review.add") }}',
			'reviewLoad': '{{ route("review.load") }}',
		}
	</script>
	@stack('scripts')
</body>
</html>


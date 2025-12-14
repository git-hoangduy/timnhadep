<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    <link rel="shortcut icon" href="{{ asset(setting('info.shortcut')) }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('website/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('website/css/slick-theme.min.css') }}">
	<link rel="stylesheet" href="{{ asset('website/css/slick.min.css') }}">
	{{-- <link rel="stylesheet" href="{{ mix('website/css/style.min.css') }}"> --}}
	<link rel="stylesheet" href="{{ mix('website/css/tinymce-template.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}?v=20250225">
</head>
<body>
    
@include('website.partials.header')
@yield('content')
@include('website.partials.footer')

<script type="text/javascript" src="{{ asset('website/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('website/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('website/js/flickity.pkgd.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('website/js/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ mix('website/js/script.min.js') }}"></script>
<script>

    if ( $('.main-carousel').length ) {
        let prevNextButtons = $('.main-carousel .carousel-cell').length > 1 ? true : false;
        $('.main-carousel').flickity({
            cellAlign: 'left',
            contain: true,
            pageDots: false,
            prevNextButtons: prevNextButtons
        });

    }

    if ( $('.review-carousel').length ) {
        let prevNextButtons = $('.review-carousel .review-carousel-cell').length > 1 ? true : false;
        $('.review-carousel').flickity({
            cellAlign: 'left',
            contain: true,
            pageDots: false,
            prevNextButtons: prevNextButtons
        });

    }

    $('.album').each(function(i, e) {

        $(e).find('.album-slide').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: '.album-nav'
        });

        $(e).find('.album-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.album-slide',
            dots: true,
            centerMode: true,
            focusOnSelect: true
        });
    })


</script>
@stack('scripts')

</body>
</html>
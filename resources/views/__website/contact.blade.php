@extends('website.master')
@section('content')

<div class="breadcrumbs bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="{{ route('home') }}">Trang chủ</a></span> / <span>Liên hệ</span></p>
            </div>
        </div>
    </div>
</div>

<div id="colorlib-contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="contact-info-wrap shadow-sm bg-white">
                    <div class="row">
                        <div class="col-md-4 py-3 text-center">
                            <p class="mb-0"><span><i class="icon-phone3"></i></span> <a href="tel://{{ setting('web.hotline') }}">{{ setting('web.hotline') }}</a></p>
                        </div>
                        <div class="col-md-4 py-3 text-center">
                            <p class="mb-0"><span><i class="icon-paperplane"></i></span> <a href="mailto:{{ setting('web.email') }}">{{ setting('web.email') }}</a></p>
                        </div>
                        <div class="col-md-4 py-3 text-center">
                            <p class="mb-0"><span><i class="icon-globe"></i></span> <a href="{{ url('/') }}">{{ request()->getHttpHost() }}</a></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="contact-wrap shadow-sm bg-white">
                    <form action="{{ route('contact') }}" class="contact-form" method="POST">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 mb-5">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-1">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success border-0 mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger border-0 mb-4">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ tên">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Số điện thoại">
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Nhập tiêu đề">
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="content" id="content" name="content" cols="30" rows="10" class="form-control" placeholder="Nhập nội dung"></textarea>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" value="Gửi yêu cầu" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>		
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div id="map" class="colorlib-map"></div>		
            </div> --}}
        </div>
    </div>
</div>

@endsection

@extends('website.master')
@section('content')
<div id="colorlib-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-wrap shadow-sm bg-white px-5 py-5 my-5">
                    @if (session('success'))
                        <div class="alert alert-success border-0 mb-5">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger border-0 mb-5">
                            {{ session('error') }}
                        </div>
                    @endif
                    <h6 class="mb-4 text-center text-uppercase">Đăng nhập</h6>
                    <form action="" class="login-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="Nhập email" value="{{ session('email') ? session('email') : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" style="height:44px">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" value="Đăng nhập" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>	
                    
                    <a class="" href="{{ route('user.register') }}"><i class="icon icon-arrow-forward"></i> Tạo tài khoản mới</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
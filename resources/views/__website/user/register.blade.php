@extends('website.master')
@section('content')
<div id="colorlib-register">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-wrap shadow-sm bg-white px-5 py-5 my-5">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 mb-5">
                            @foreach ($errors->all() as $error)
                                <p class="mb-1">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <h6 class="mb-4 text-center text-uppercase">Tạo tài khoản mới</h6>
                    <form action="" class="login-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="Nhập email">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" style="height:44px">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" style="height:44px">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" value="Đăng ký" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>	
                    
                    <a class="" href="{{ route('user.login') }}"><i class="icon icon-arrow-back"></i> Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
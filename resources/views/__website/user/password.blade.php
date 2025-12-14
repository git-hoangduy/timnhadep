@extends('website.master')
@section('content')
<div id="colorlib-login">
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-3 mt-4">
                @include('website.user.sidebar')
            </div>
            <div class="col-md-9 mt-4">
                <form action="{{ route('user.password') }}" method="POST" class="bg-white shadow-sm px-4 py-3">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 mb-4">
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
                    <div class="form-group">
                        <label for="">Mật khẩu</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
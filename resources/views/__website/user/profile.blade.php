@extends('website.master')
@section('content')
<div id="colorlib-login">
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-3 mt-4">
                @include('website.user.sidebar')
            </div>
            <div class="col-md-9 mt-4">
                <form action="{{ route('user.profile') }}" method="POST" class="bg-white shadow-sm px-4 py-3">
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
                        <label for="">Tên của bạn</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
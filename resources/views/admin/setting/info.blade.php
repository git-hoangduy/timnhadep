@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('admin.includes.notification')
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Thông tin tổng quan
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-4 text-muted">Cập nhật các thông tin cơ bản của Website, thông tin liên hệ</h6>
                    <form action="{{ route('setting.info') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Tên trường học</label>
                            <input type="text" class="form-control" name="name" value="{{ setting('info.name') }}">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label>Hotline</label>
                                <input type="text" class="form-control" name="hotline" value="{{ setting('info.hotline') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Điện thoại</label>
                                <input type="text" class="form-control" name="phone" value="{{ setting('info.phone') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Địa chỉ email</label>
                                <input type="text" class="form-control" name="email" value="{{ setting('info.email') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Địa chỉ</label>
                            <input class="form-control" type="text" name="address" value="{{ setting('info.address') }}">
                        </div>
                        <div class="mb-3">
                            <label>Iframe (Google map)</label>
                            <textarea name="iframe" rows="4" class="form-control">{{ setting('info.iframe') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo trang web</label>
                            <input class="form-control" type="file" id="logo" name="logo" accept="image/*">
                            @if (setting('info.logo') != '')
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset(setting('info.logo')) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="shortcut" class="form-label">Shortcut trang web</label>
                            <input class="form-control" type="file" id="shortcut" name="shortcut" accept="image/*">
                            @if (setting('info.shortcut') != '')
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset(setting('info.shortcut')) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Copyright</label>
                            <input class="form-control" type="text" name="copyright" value="{{ setting('info.copyright') }}">
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

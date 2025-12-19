@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('admin.includes.notification')
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Liên kết mạng xã hội
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-4 text-muted">Thêm các liên kết đến các trang mạng xã hội của bạn trên Website</h6>
                    <form action="{{ route('setting.social') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Facebook - <b>[FACEBOOK]</b></label>
                            <input type="text" class="form-control" name="facebook" value="{{ setting('social.facebook') }}">
                        </div>
                        <div class="mb-3">
                            <label>Tiktok - <b>[TIKTOK]</b></label>
                            <input type="text" class="form-control" name="tiktok" value="{{ setting('social.tiktok') }}">
                        </div>
                        <div class="mb-3">
                            <label>Youtube - <b>[YOUTUBE]</b></label>
                            <input type="text" class="form-control" name="youtube" value="{{ setting('social.youtube') }}">
                        </div>
                        <div class="mb-3">
                            <label>Instagram - <b>[INSTAGRAM]</b></label>
                            <input type="text" class="form-control" name="instagram" value="{{ setting('social.instagram') }}">
                        </div>
                        <!-- <div class="mb-3">
                            <label>Zalo - <b>[ZALO]</b></label>
                            <input type="text" class="form-control" name="zalo" value="{{ setting('social.zalo') }}">
                        </div> -->
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

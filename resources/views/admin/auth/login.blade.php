@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mt-5">
                <div class="card-header">Đăng nhập</div>

                <div class="card-body px-4">
                    @include('admin.includes.notification')
                    <form method="POST" action="{{ route('admin.postLogin') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="mb-1" for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="mb-1" for="password">Mật khẩu</label>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Nhớ lần đăng nhập này
                                </label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Quên mật khẩu
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-primary">
                                    Đăng nhập
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {

        $("form").validate({
            rules: {
                "email": {
                    required: true,
                    email: true,
                },
                "password": {
                    required: true,
                },
            }
        });
    });
</script>
@endpush
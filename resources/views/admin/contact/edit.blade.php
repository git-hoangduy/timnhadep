@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa yêu cầu
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">Quay lại</a>
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('contact.update', $contact->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1" {{ $contact->status == 1 ? 'selected' : '' }}>Đã phản hồi</option>
                                <option value="0" {{ $contact->status == 0 ? 'selected' : '' }}>Chưa phản hồi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

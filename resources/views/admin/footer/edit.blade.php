@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa footer
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('footer.update', $footer->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="required">Tên mục nổi bật</label>
                            <input type="text" class="form-control" name="name" value="{{ $footer->name }}">
                        </div>
                        <div class="mb-3">
                            <label>Nội dung</label>
                            <textarea name="content" rows="4" class="form-control tinymce">{!! $footer->content !!}</textarea>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control select2">
                                    <option value="1" {{ $footer->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ $footer->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                                </select>
                            </div>
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

@push('scripts')
<script>
    $(document).ready(function() {

        $("form").validate({
            rules: {
                "category_id": {
                    required: true,
                },
                "name": {
                    required: true,
                },
            }
        });
    });
</script>
@endpush

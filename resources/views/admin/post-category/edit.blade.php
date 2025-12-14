@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa danh mục bài viết
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('post-category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
  
                        @if (config('post.category_level') > 1)
                            <div class="mb-3">
                                <label>Danh mục cha</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="">- Không có -</option>
                                    @foreach($categories as $key => $item)
                                        @include('admin.post-category.includes.option', ['category' => $item, 'selected' => $category->parent_id])
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="required">Tên danh mục</label>
                            <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh</label>
                            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                            @if ($category->image != '')
                                <img src="{{ asset($category->image) }}" class="mt-2 border rounded p-1" width="50" height="50">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="required">Trạng thái</label>
                            <select name="status" class="form-control select2">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                            </select>
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

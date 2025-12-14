@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Chỉnh sửa danh mục
                </div>
                <div class="card-body">
                    @include('admin.includes.notification')
                    <form action="{{route('product-category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Use normal loop for option --}}
                        {{-- <div class="mb-3">
                            <label>Danh mục cha</label>
                            <select class="form-control select2" name="parent_id">
                                <option value="">- Không có -</option>
                                @php 
                                    $prefix = [
                                        1 => '',
                                        2 => '\____',
                                        3 => '\________',
                                    ]
                                @endphp
                                @foreach($categories as $key => $lv1)
                                    <option value='{{ $lv1->id }}' {{ $category->parent_id && $category->parent_id == $lv1->id ? 'selected' : '' }}>{{ $prefix[$lv1->level].' '.$lv1->name }}</option>
                                    @if($lv1->children->count())
                                        @foreach($lv1->children as $lv2)
                                            <option value='{{$lv2->id}}' {{ $category->parent_id && $category->parent_id == $lv2->id ? 'selected' : '' }}>{{ $prefix[$lv2->level].' '.$lv2->name }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div> --}}

                        {{-- Use auto loop by level for option --}}
                        @if (config('product.category_level') > 1)
                            <div class="mb-3">
                                <label>Danh mục cha</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="">- Không có -</option>
                                    @foreach($categories as $key => $item)
                                        @include('admin.product-category.includes.option', ['category' => $item, 'selected' => $category->parent_id])
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
                                <img class="preview-image w-25 mt-2 rounded" src="{{ asset($category->image) }}">
                            @else
                                <img class="preview-image w-25 mt-2 rounded d-none">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Trạng thái</label>
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

@push('scripts')
<script>
    $("form").validate({
		rules: {
			"name": {
				required: true,
			},
		}
	});
</script>
@endpush


@php
    $maxLevelSelection = config('post.category_level');
    $prefix = ['1' => ''];
    if ($maxLevelSelection > 1) {
        for ($i = 1; $i < $maxLevelSelection; $i ++ ) {
            $str = '\\'.str_repeat('_', ($i*4));
            $prefix[$i+1] = $str;
        }
    }
@endphp

<tr data-id="{{ $item->id }}">
    <td class="text-center">{{ $item->level }}</td>
    <td>{!! $prefix[$category->level] !!} {{ $category->name }}</td>
    <td>{{ $item->parent ? $item->parent->name : '' }}</td>
    <td>
        @if($item->image != '')
            <img src="{{ asset($item->image) }}" width="25" height="25">
        @else
            <img src="{{ asset('uploads/default.png') }}" width="25" height="25">
        @endif
    </td>
    <td class="text-center">
        <div class="form-check d-inline-block form-switch">
            <input class="form-check-input status-switch" type="checkbox" {{ $item->status == 1 ? 'checked' : '' }}>
        </div>
    </td>
    <td>{{ $item->updated_at }}</td>
    <td>
        <a href="{{ route('post-category.edit', $category->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
        <form action="{{ route('post-category.destroy', $category->id) }}" method="POST" class="d-inline-block">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
        </form>
    </td>
</tr>

@if($category->children->count() > 0)
    @foreach($category->children as $item)
        @include('admin.post-category.includes.loop', ['category' => $item])
    @endforeach
@endif
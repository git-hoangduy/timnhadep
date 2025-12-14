@php
    $prefix = [
        '1' => '',
        '2' => '<span class="text-secondary">\____</span>',
        '3' => '<span class="text-muted">\________</span>',
    ];
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
        <a href="{{ route('product-category.edit', $category->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
        <form action="{{ route('product-category.destroy', $category->id) }}" method="POST" class="d-inline-block">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-sm btn-danger btnDelete">Xóa</button>
        </form>
    </td>
</tr>

@if($category->children->count() > 0)
    @foreach($category->children as $item)
        @include('admin.product-category.includes.loop', ['category' => $item])
    @endforeach
@endif
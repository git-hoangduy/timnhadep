@php

    $maxLevelSelection = config('page.category_level') - 1;
    if (isset($full) && $full == 1) {
        $maxLevelSelection = config('page.category_level');
    }

    $prefix = ['1' => ''];
    if ($maxLevelSelection > 1) {
        for ($i = 1; $i < $maxLevelSelection; $i ++ ) {
            $str = '\\'.str_repeat('_', ($i*4));
            $prefix[$i+1] = $str;
        }
    }

@endphp

<option value='{{$category->id}}' {{ isset($selected) && $selected == $category->id ? 'selected' : '' }}>{{ $prefix[$category->level].' '.$category->name }}</option>

@if ($category->level < $maxLevelSelection)
    @if ($category->children->count())
        @foreach($category->children as $key => $item)
            @include('admin.page-category.includes.option', ['category' => $item])
        @endforeach
    @endif
@endif
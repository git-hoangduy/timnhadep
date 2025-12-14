@extends('layouts.app')
@section('content')

@php
    $productAttributes = $product->attributes ?? json_encode([]);
@endphp

<div class="container">
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.includes.notification')
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Chỉnh sửa sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label>Loại sản phẩm</label>
                                <select name="type" class="form-control select2">
                                    <option value="1" {{ $product->type == 1 ? 'selected' : '' }}>Đơn giản</option>
                                    {{-- <option value="2" {{ $product->type == 2 ? 'selected' : '' }}>Thuộc tính</option> --}}
                                    {{-- <option value="3" {{ $product->type == 3 ? 'selected' : '' }}>Liên kết</option> --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control select2">
                                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            {{-- <div class="col-md-6">
                                <label class="required">Danh mục</label>
                                <select class="form-control select2" name="category_id">
                                    <option value="">- Không có -</option>
                                    @php 
                                        $prefix = [
                                            1 => '',
                                            2 => '\____',
                                            3 => '\________',
                                        ]
                                    @endphp
                                    @foreach($categories as $key => $lv1)
                                        <option value='{{$lv1->id}}' {{ $product->category_id == $lv1->id ? 'selected' : '' }}>{{ $prefix[$lv1->level].' '.$lv1->name }}</option>
                                        @if($lv1->children->count())
                                            @foreach($lv1->children as $lv2)
                                                <option value='{{$lv2->id}}' {{ $product->category_id == $lv2->id ? 'selected' : '' }}>{{ $prefix[$lv2->level].' '.$lv2->name }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-6">
                                <label class="required">Danh mục</label>
                                <select class="form-control select2" name="category_id">
                                    <option value="">- Không có -</option>
                                    @foreach($categories as $key => $item)
                                        @include('admin.product-category.includes.option', ['category' => $item, 'selected' => $product->category_id, 'full' => 1])
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label>Thương hiệu</label>
                                <select class="form-control select2" name="brand_id">
                                    <option value="">- Không có -</option>
                                    @foreach($brands as $key => $item)
                                        <option value="{{$item->id}}" {{ $product->brand_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="required">Tên sản phẩm</label>
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label>Mã sản phẩm</label>
                                <input type="text" class="form-control" name="sku" value="{{ $product->sku }}">
                            </div>
                            <div class="col-md-3">
                                <label class="d-block">&nbsp;</label>
                                <button type="button" class="btn btn-primary randomProductCode">Tạo ngẫu nhiên</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh (tối đa 10 hình)</label>
                            <input class="form-control upload-images" type="file" id="formFile" accept="image/*" multiple>
                            <div class="preview-images" style="display: {{ $product->images->count() ? 'flex' : 'none' }}">
                                @foreach($product->images as $key => $image)
                                    <div class="preview-item" data-id="{{ $image->id }}" data-file="{{ $image->name }}">
                                        <img src="{{ asset($image->image) }}">
                                        <div class="form-check check-avatar">
                                            <input class="form-check-input" type="radio" name="is_avatar" id="cbav{{ $key }}" value="{{ $image->name }}" {{ $image->is_avatar == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cbav{{ $key }}">Ảnh đại diện</label>
                                        </div>
                                        <span class="delete-image"></span>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="removeImages">
                        </div>
                        <div class="mb-3">
                            <div class="accordion" id="accordionFlush">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Thông tin vận chuyển
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse bg-white collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
                                        <div class="accordion-body row">
                                            <div class="col-md-3">
                                                <label>Trọng lượng (kg)</label>
                                                <input type="number" min="0" class="form-control" name="weight" value="{{ $product->weight }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Chiều rộng (cm)</label>
                                                <input type="number" min="0" class="form-control" name="width" value="{{ $product->width }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Chiều cao (cm)</label>
                                                <input type="number" min="0" class="form-control" name="height" value="{{ $product->height }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Chiều dài (cm)</label>
                                                <input type="number" min="0" class="form-control" name="length" value="{{ $product->length }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-type mb-3 d-none" data-type="1">
                            <div class="mb-3 row">
                                <div class="col-md-3">
                                    <label class="">Số lượng</label>
                                    <input type="number" min="0" class="form-control" name="stock" value="{{ $product->stock }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Giá thường</label>
                                    <input type="number" min="0" class="form-control" name="price" value="{{ $product->price }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Giá khuyến mãi</label>
                                    <input type="number" min="0" class="form-control" name="price_discount" value="{{ $product->price_discount }}">
                                </div>
                            </div>
                        </div>
                        <div class="info-type mb-3 d-none" data-type="2">
                            <div class="attributes border rounded px-3">
                                <p class="mt-3"><strong>Chọn thuộc tính</strong></p>
                                @foreach($attributes as $key => $attribute)
                                <div class="row my-4 attribute-item" data-id="{{ $attribute->id }}">
                                    <div class="col-2">{{ $attribute->name }}</div>
                                    <div class="col-10">
                                        @if ($attribute->values->count())
                                            @foreach($attribute->values as $key2 => $value)
                                                @if($attribute->type == 1)
                                                    <div class="form-check d-inline-block mb-2 me-4">
                                                        <input class="form-check-input" type="checkbox" value="{{ $value->id }}" id="cb-{{$key}}-{{ $key2 }}" name="attr[{{$attribute->id}}][]" data-text="{{ $value->text }}">
                                                        <label class="form-check-label" for="cb-{{$key}}-{{ $key2 }}" style="padding:1px 10px; border-radius:30px;font-size: 12px;font-weight: 500;border: 1px solid #b9b9b9;">
                                                            {{ $value->text }}
                                                        </label>
                                                    </div>
                                                @else
                                                    <div class="form-check d-inline-block mb-2 me-4">
                                                        <input class="form-check-input" type="checkbox" value="{{ $value->id }}" id="cb-{{$key}}-{{ $key2 }}" name="attr[{{$attribute->id}}][]" data-text="{{ $value->text }}">
                                                        <label class="form-check-label" for="cb-{{$key}}-{{ $key2 }}" style="background: {{ $value->color }}; padding:2px 10px; border-radius:30px;font-size: 12px;color: #fff;font-weight: 500;">
                                                            {{ $value->text }}
                                                        </label>
                                                    </div>
                                                @endif

                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                <button type="button" class="btn btn-sm btn-primary mb-4 addVariants">Tạo các biến thể</button>
                            </div>
                            @if ($product->variants->count())
                                <div class="variants border rounded px-3 mt-3">
                                    <p class="mt-3"><strong>Biến thể</strong></p>
                                    <div class="border-bottom mb-3">
                                        <div class="row">
                                            <div class="col-2">Phân loại</div>
                                            <div class="col-2">Mã SKU</div>
                                            <div class="col-2">Giá bán</div>
                                            <div class="col-2">Giá khuyến mãi</div>
                                            <div class="col-2">Số lượng</div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="variant-list">
                                        @foreach($product->variants as $variant)
                                        <div class="variant-item mb-3">
                                            <div class="row">
                                                <div class="col-2">
                                                    <input type="hidden" name="variant_id[]" value="{{ $variant->id }}">
                                                    <input type="text" class="form-control" name="variant[]" value="{{ $variant->variant }}" readonly>
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" class="form-control" name="variant_sku[]" value="{{ $variant->variant_sku }}">
                                                </div>
                                                <div class="col-2">
                                                    <input type="number" class="form-control" name="variant_price[]" placeholder="0" value="{{ $variant->variant_price }}">
                                                </div>
                                                <div class="col-2">
                                                    <input type="number" class="form-control" name="variant_price_discount[]" placeholder="0" value="{{ $variant->variant_price_discount }}">
                                                </div>
                                                <div class="col-2">
                                                    <input type="number" class="form-control" name="variant_stock[]" placeholder="0" value="{{ $variant->variant_stock }}">
                                                </div>
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-warning deleteVariant">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="removeVariants">
                                </div>
                            @endif
                        </div>
                        <div class="info-type mb-3 d-none" data-type="3">
                            <div class="mb-3">
                                <label class="">Link sản phẩm</label>
                                <input type="text" class="form-control" name="link" value="{{ $product->link }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Mô tả ngắn</label>
                            <textarea name="excerpt" rows="4" class="form-control">{{ $product->excerpt }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Mô tả chi tiết</label>
                            <textarea name="description" rows="4" class="form-control tinymce" >{!! $product->description !!}</textarea>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Tối ưu SEO
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Meta keywords (SEO)</label>
                            <textarea name="meta_keywords" rows="4" class="form-control" placeholder="Mỗi từ khóa cách nhau bởi dấu ,">{{ $product->meta_keywords }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Meta description (SEO)</label>
                            <textarea name="meta_description" rows="4" class="form-control">{{ $product->meta_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="variant-item-laytout d-none">
    <div class="variant-item mb-3">
        <div class="row">
            <div class="col-2">
                <input type="text" class="form-control" name="variant[]" readonly>
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="variant_sku[]">
            </div>
            <div class="col-2">
                <input type="number" class="form-control" name="variant_price[]" placeholder="0">
            </div>
            <div class="col-2">
                <input type="number" class="form-control" name="variant_price_discount[]" placeholder="0">
            </div>
            <div class="col-2">
                <input type="number" class="form-control" name="variant_stock[]" placeholder="0">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-warning deleteVariant">Xóa</button>
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

        productTypeControls();

        let productAttributes = {!! ($productAttributes) !!}
        for (let attribute of productAttributes) {
            for (let value of attribute.values) {
                $(`.attribute-item[data-id="${attribute.id}"] input[value="${value.id}"]`).prop('checked', true);
            }
        }
    });

    $('select[name="type"]').change(function() {
        productTypeControls();
    });

    function productTypeControls() {
        let type = $('select[name="type"]').val();
        $('.info-type').addClass('d-none');
        $(`.info-type[data-type="${type}"]`).removeClass('d-none');
    }

    $('.randomProductCode').click(function() {
        let now = new Date();
        let seconds = Math.floor(now.getTime() / 1000);
        let code = 'P' + seconds;
        $('input[name="sku"]').val(code);
    });

    $('.addVariants').click(function() {

        var attributes = [];
        $('.attribute-item').each(function(i, e){
            let attributeId = $(e).attr('data-id');
            let checkedValues = [];
            $(e).find('.form-check').each(function(i2, e2){
                let checkbox = $(e2).find('input');
                if (checkbox.is(':checked')) {
                    checkedValues.push(checkbox.val());
                }
            });
            attributes.push(checkedValues);
        });
        
        var filteredAttributes = removeEmptyArrays(attributes);
        var variants = generateVariations(filteredAttributes);

        if (variants.length > 0) {
            $('.variants').removeClass('d-none');
            $('.variants .variant-list').empty();
            for (let [index, variant] of variants.entries()) {
                
                let variantNames = [];
                for(let item of variant) {
                    variantNames.push( $(`.attribute-item input[value="${item}"]`).attr('data-text') );
                }

                var item = $('.variant-item-laytout .variant-item').clone();
                item.find('input[name="variant[]"]').val(variantNames.join(', '));
                $('.variants .variant-list').append(item);
            }
        }
    });

    $(document).on('click', '.deleteVariant', function() {

        let variantId = $(this).closest('.variant-item').find('input[name="variant_id[]"]').val() || null;
        if (variantId) {
            let removeVariants = $('input[name="removeVariants"]').val().split(',');
            removeVariants.push(variantId);
            $('input[name="removeVariants"]').val(removeVariants.join(','));
        }

        $(this).closest('.variant-item').remove();

        if ( $('.variants .variant-item').length <= 0 ) {
            $('.variants').addClass('d-none');
        }
    });

    $('.upload-images').on('change', function() {
        let limit = 10;
        let files = $(this)[0].files;
        let countItems = $('.preview-images .preview-item').length;
        let space = limit - countItems;

        if (files.length > space) {
            alert(`Chỉ được chọn tối đa ${limit} hình ảnh!`);
            return false;
        }

        for(const file of files) {

            if ($(`.preview-images .preview-item[data-file="${file.name}"]`).length > 0) {
                alert(`Hình ảnh có tên tương tự đã được thêm!`);
                return false;
            }

            let reader = new FileReader();
            reader.onload = function(){
                
                let index = $('.preview-images .preview-item').length;

                let previewHTML = `<div class="rounded preview-item" data-file="${file.name}">`
                    previewHTML += `<input type="file" name="images[]" class="d-none" />`
                    previewHTML += `<img src="${reader.result}">`
                    previewHTML += `<div class="form-check check-avatar">`
                    previewHTML += `<input class="form-check-input" type="radio" name="is_avatar" id="cbav${index}" value="${file.name}">`
                    previewHTML += `<label class="form-check-label" for="cbav${index}">Ảnh đại diện</label>`
                    previewHTML += `</div>`
                    previewHTML += `<span class="delete-image"></span>`
                    previewHTML += `</div>`;
                
                $('.preview-images').append(previewHTML);

                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.querySelector(`.preview-item[data-file="${file.name}"] input[name="images[]"]`).files = dataTransfer.files;
            };
            reader.readAsDataURL(file);
        }

        $('.preview-images').css('display', 'flex');
    });

    $(document).on('click', '.preview-item .delete-image', function() {

        let imageId = $(this).closest('.preview-item').attr('data-id');
        if (imageId) {
            let removeImages = $('input[name="removeImages"]').val().split(",");
            removeImages.push(imageId);
            $('input[name="removeImages"]').val(removeImages.join(","));
        }

        $(this).closest('.preview-item').remove();

        let countItems = $('.preview-images .preview-item').length;
        if (countItems <= 0) {
            $('.preview-images').css('display', 'none');
        }
    });

</script>
@endpush

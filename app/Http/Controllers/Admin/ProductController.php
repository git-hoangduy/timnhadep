<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\AttributeValue;

class ProductController extends Controller
{
    private $PATH_IMAGE = 'uploads/products/';

    public function index(Request $request)
    {
        $query = Product::query();

        if (!empty($request->keyword)) {
            
            $query->where(function ($q) use ($request) {
                $q->where('name','LIKE','%'.$request->keyword.'%')
                ->orWhere('excerpt', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%')
                ->orWhere('meta_keywords', 'like', '%' . $request->keyword . '%')
                ->orWhere('meta_description', 'like', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        if (!empty($request->brand)) {
            $query->where('brand_id', $request->brand);
        }

        $products = $query->orderBy('id', 'desc')->paginate(20);
        $categories = ProductCategory::where(['status' => 1, 'level' => 1])->get();
        $brands = Brand::where(['status' => 1])->get();
        return view('admin.product.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = ProductCategory::where(['status' => 1, 'level' => 1])->get();
        $brands = Brand::where(['status' => 1])->get();
        $attributes = Attribute::where(['status' => 1])->get();
        return view('admin.product.create', compact('categories', 'brands', 'attributes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type'             => 'required',
            'status'           => 'required',
            'category_id'      => 'required',
            'brand_id'         => 'nullable',
            'sku'              => 'nullable|unique:products,sku',
            'name'             => 'required',
            'stock'            => 'numeric|min:0|nullable',
            'price'            => 'numeric|min:0|nullable',
            'price_discount'   => 'numeric|min:0|nullable',
            'weight'           => 'numeric|min:0|nullable',
            'width'            => 'numeric|min:0|nullable',
            'height'           => 'numeric|min:0|nullable',
            'length'           => 'numeric|min:0|nullable',
        ]);

        $price = preg_replace('/[^0-9]/', '', $request->price);
        $priceDiscount = preg_replace('/[^0-9]/', '', $request->price_disount);
        $discountRate = round((1-($priceDiscount/$price))*100, 0);

        $data = [
            'type'             => $request->type,
            'status'           => $request->status,
            'category_id'      => $request->category_id,
            'brand_id'         => $request->brand_id,
            'sku'              => $request->sku,
            'name'             => $request->name,
            'stock'            => $request->stock,
            'price'            => $price,
            'price_discount'   => $priceDiscount,
            'discount_rate'    => $discountRate,
            'weight'           => $request->weight,
            'width'            => $request->width,
            'height'           => $request->height,
            'length'           => $request->length,
            'excerpt'          => $request->excerpt,
            'description'      => $request->description,
            'link'             => $request->link,
            'meta_keywords'    => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ];

        $slug  = Str::slug($data['name']);
        $check = Product::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }

        $data['slug'] = $slug;

        $product = Product::create($data);

        if ($product) {

            if (!empty($request->attr)) {

                $productAttributes = [];
                foreach($request->attr as $key => $value) {
                    $attribute = Attribute::select('id', 'name', 'slug', 'type')->find($key);
                    $attributeValues = AttributeValue::select('id', 'text', 'color')->whereIn('id', $value)->get();
                    $attribute->values = $attributeValues;
                    $productAttributes [] = $attribute;
                }
                $product->fill(['attributes' => $productAttributes])->save();
            }

            $countVariants = count(($request->variant ?? array()));
            if ($countVariants > 0) {
                for ($i = 0; $i < $countVariants; $i++) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'variant' => $request->variant[$i],
                        'variant_sku' => $request->variant_sku[$i],
                        'variant_price' => $request->variant_price[$i],
                        'variant_price_discount' => $request->variant_price_discount[$i],
                        'variant_stock' => $request->variant_stock[$i],
                    ]);
                }
            }

            if($request->hasFile('images')) {
                foreach($request->file('images') as $key => $file){
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = $file->getClientOriginalName();
                    $fileNameHash = md5(time().$data['slug'].$key).'.'.$fileExtension;
                    $file->move($this->PATH_IMAGE, $fileNameHash);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName,
                    ]);
                }
            }

            if (!empty($request->is_avatar)) {
                ProductImage::where(['product_id' => $product->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            request()->session()->flash('success', 'Thêm sản phẩm thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('product.index');

    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::where(['status' => 1, 'level' => 1])->get();
        $brands = Brand::where(['status' => 1])->get();
        $attributes = Attribute::where(['status' => 1])->get();
        return view('admin.product.edit', compact('categories', 'brands', 'product', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $this->validate($request, [
            'type'             => 'required',
            'status'           => 'required',
            'category_id'      => 'required',
            'brand_id'         => 'nullable',
            'sku'              => 'nullable|unique:products,sku,'.$id,
            'name'             => 'required',
            'stock'            => 'numeric|min:0|nullable',
            'price'            => 'numeric|min:0|nullable',
            'price_discount'   => 'numeric|min:0|nullable',
            'weight'           => 'numeric|min:0|nullable',
            'width'            => 'numeric|min:0|nullable',
            'height'           => 'numeric|min:0|nullable',
            'length'           => 'numeric|min:0|nullable',
        ]);

        $price = preg_replace('/[^0-9]/', '', $request->price);
        $priceDiscount = preg_replace('/[^0-9]/', '', $request->price_disount);
        $discountRate = round((1-($priceDiscount/$price))*100, 0);

        $data = [
            'type'             => $request->type,
            'status'           => $request->status,
            'category_id'      => $request->category_id,
            'brand_id'         => $request->brand_id,
            'sku'              => $request->sku,
            'name'             => $request->name,
            'stock'            => $request->stock,
            'price'            => $price,
            'price_discount'   => $priceDiscount,
            'discount_rate'    => $discountRate,
            'weight'           => $request->weight,
            'width'            => $request->width,
            'height'           => $request->height,
            'length'           => $request->length,
            'excerpt'          => $request->excerpt,
            'description'      => $request->description,
            'link'             => $request->link,
            'meta_keywords'    => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ];

        $slug  = Str::slug($data['name']);
        $check = Product::where(['slug' => $slug])->where('id', '<>', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if ($product->fill($data)->save()) {

            if (!empty($request->attr)) {

                $productAttributes = [];
                foreach($request->attr as $key => $value) {
                    $attribute = Attribute::select('id', 'name', 'slug', 'type')->find($key);
                    $attributeValues = AttributeValue::select('id', 'text', 'color')->whereIn('id', $value)->get();
                    $attribute->values = $attributeValues;
                    $productAttributes [] = $attribute;
                }
                $product->fill(['attributes' => $productAttributes])->save();
            }

            if (!empty($request->removeVariants)) {
                $removeVariants = array_filter(explode(',', $request->removeVariants));
                ProductVariant::whereIn('id', $removeVariants)->delete();
            }

            $countVariants = count(($request->variant ?? array()));
            if ($countVariants > 0) {
                for ($i = 0; $i < $countVariants; $i++) {

                    $productVariant = ProductVariant::find($request->variant_id[$i]);
                    
                    if (!empty($productVariant)) {
                        $productVariant->update([
                            'product_id' => $product->id,
                            'variant' => $request->variant[$i],
                            'variant_sku' => $request->variant_sku[$i],
                            'variant_price' => $request->variant_price[$i],
                            'variant_price_discount' => $request->variant_price_discount[$i],
                            'variant_stock' => $request->variant_stock[$i],
                        ]);
                    } else {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'variant' => $request->variant[$i],
                            'variant_sku' => $request->variant_sku[$i],
                            'variant_price' => $request->variant_price[$i],
                            'variant_price_discount' => $request->variant_price_discount[$i],
                            'variant_stock' => $request->variant_stock[$i],
                        ]);
                    }  
                }
            }

            if (!empty($request->removeImages)) {
                $removeImages = array_filter(explode(',', $request->removeImages));
                $productImages = ProductImage::whereIn('id', $removeImages)->get();
                foreach($productImages as $image) {
                    if(File::exists($image->image)){
                        File::delete($image->image);
                    }
                    $image->delete();
                }
                
            }

            if ($request->hasFile('images')) {

                foreach($request->file('images') as $key => $file){
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = $file->getClientOriginalName();
                    $fileNameHash = md5(time().$data['slug'].$key).'.'.$fileExtension;
                    $file->move($this->PATH_IMAGE, $fileNameHash);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName
                    ]);
                }
            }

            if (!empty($request->is_avatar)) {
                ProductImage::where(['product_id' => $product->id])->update(['is_avatar' => 0]);
                ProductImage::where(['product_id' => $product->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            request()->session()->flash('success', 'Cập nhật sản phẩm thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->delete()){

            $images = ProductImage::where('product_id', $id)->get();
            if ($images->count()) {
                foreach($images as $image) {
                    if(File::exists($image->image)){
                        File::delete($image->image);
                    }
                    $image->delete();
                }
            }

            $variants = ProductVariant::where('product_id', $id)->delete();

            request()->session()->flash('success','Xóa sản phẩm thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('product.index');
    }

    public function searchProduct(Request $request) {

        $result['status'] = 'error';

        if ($request->search) {
            $query = Product::query();
            $query->where(function ($q) use ($request) {
                $q->where('name', "like", "%" . $request->search . "%");
                $q->orWhere('slug', "like", "%" . $request->search . "%");
                $q->orWhere('excerpt', "like", "%" . $request->search . "%");
                $q->orWhere('description', "like", "%" . $request->search . "%");
                $q->orWhere('price', "like", "%" . $request->search . "%");
            });
            $products = $query->selectRaw('id, concat(name, " - ", price, " đ") as text')->where(['status' => 1])->limit(10)->get();
            if ($products->count()) {
                $result['status'] = 'success';
                $result['data'] = $products;
            }
        }

        return response()->json($result);
    }

    public function getProduct(Request $request) {

        $result['status'] = 'error';

        $product = Product::where(['status' => 1, 'id' => $request->productId])->first();
        if (!empty($product)) {
            $result['status'] = 'success';
            $result['data'] = $product;
        }

        return response()->json($result);
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Product::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

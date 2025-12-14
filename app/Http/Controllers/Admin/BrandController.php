<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Models\Brand;

class BrandController extends Controller
{
    private $PATH_IMAGE = 'uploads/brands/';

    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(20);
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data  = $request->all();
        $slug  = Str::slug($data['name']);
        $check = Brand::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['slug']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        } else {
            $data['image'] = null;
        }

        if(Brand::create($data)){
            request()->session()->flash('success', 'Thêm thương hiệu thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('brand.index');

    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data  = $request->all();
        $slug  = Str::slug($data['name']);
        $check = Brand::where('slug', $slug)->where('id', '!=', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($request->hasFile('image')) {

            if ($brand->image != '') {
                if(File::exists($brand->image)){
                    File::delete($brand->image);
                }
            }

            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['slug']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        }
        
        if($brand->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật thương hiệu thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('brand.index');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $image = $brand->image;
        if($brand->delete()){
            if(File::exists($image)){
                File::delete($image);
            }
            request()->session()->flash('success','Xóa thương hiệu thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('brand.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Brand::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

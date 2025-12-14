<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Models\PageCategory;
use App\Models\Page;

class PageCategoryController extends Controller
{
    private $PATH_IMAGE = 'uploads/page-categories/';

    public function index()
    {
        $categories = PageCategory::where('level', 1)->orderBy('id', 'desc')->get();
        return view('admin.page-category.index', compact('categories'));
    }

    public function create()
    {
        $categories = PageCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.page-category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'parent_id' => 'nullable',
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data  = $request->all();
        $slug  = Str::slug($data['name']);
        $check = PageCategory::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $parent = PageCategory::where('id', ($data['parent_id'] ?? 0))->first();
        $data['slug'] = $slug;
        $data['level'] = ($parent->level ?? 0) + 1;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['slug']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        } else {
            $data['image'] = null;
        }

        if(PageCategory::create($data)){
            request()->session()->flash('success', 'Thêm danh mục trang thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('page-category.index');

    }

    public function edit($id)
    {
        $category = PageCategory::find($id);
        $categories = PageCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.page-category.edit', compact('categories', 'category'));
    }

    public function update(Request $request, $id)
    {
        $category = PageCategory::findOrFail($id);

        $this->validate($request, [
            'parent_id' => 'nullable',
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data  = $request->all();
        $slug  = Str::slug($data['name']);
        $check = PageCategory::where('slug', $slug)->where('id', '!=', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $parent = PageCategory::where('id', $data['parent_id'])->first();
        $data['slug'] = $slug;
        $data['level'] = ($parent->level ?? 0) + 1;

        if($request->hasFile('image')) {

            if ($category->image != '') {
                if(File::exists($category->image)){
                    File::delete($category->image);
                }else{
                    echo 'File does not exists.';
                }
            }

            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['slug']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        } else {
            $data['image'] = null;
        }

        if($category->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật danh mục trang thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('page-category.index');
    }

    public function destroy($id)
    {
        $category = PageCategory::findOrFail($id);
        $pages = Page::where('category_id', $id)->first();

        if ($category->children->count()) {
            request()->session()->flash('error','Xóa danh mục phụ thuộc trước.');
            return redirect()->route('page-category.index');
        }
        
        if (!empty($pages)) {
            request()->session()->flash('error','Xóa trang phụ thuộc trước.');
            return redirect()->route('page-category.index');
        }
        
        $image = $category->image;
        if($category->delete()){

            if(File::exists($image)){
                File::delete($image);
            }

            request()->session()->flash('success','Xóa danh mục trang thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }

        return redirect()->route('page-category.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                PageCategory::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

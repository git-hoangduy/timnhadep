<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

use App\Models\Banner;

class BannerController extends Controller
{
    private $PATH_IMAGE = 'uploads/banners/';

    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->paginate(20);
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data  = $request->all();

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time()).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        } else {
            $data['image'] = null;
        }

        if(Banner::create($data)){
            request()->session()->flash('success', 'Thêm banner thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('banner.index');

    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();

        if($request->hasFile('image')) {

            if ($banner->image != '') {
                if(File::exists($banner->image)){
                    File::delete($banner->image);
                }
            }

            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time()).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        }

        if($banner->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật banner thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('banner.index');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $image = $banner->image;
        if($banner->delete()){
            if(File::exists($image)){
                File::delete($image);
            }
            request()->session()->flash('success','Xóa banner thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('banner.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Banner::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

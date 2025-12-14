<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

use App\Models\Footer;

class FooterController extends Controller
{
    public function index()
    {
        $footers = Footer::orderBy('id', 'desc')->paginate(20);
        return view('admin.footer.index', compact('footers'));
    }

    public function create()
    {
        return view('admin.footer.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data  = $request->all();

        if(Footer::create($data)){
            request()->session()->flash('success', 'Thêm footer thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('footer.index');

    }

    public function edit($id)
    {
        $footer = Footer::find($id);
        return view('admin.footer.edit', compact('footer'));
    }

    public function update(Request $request, $id)
    {
        $footer = Footer::findOrFail($id);

        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();

        if($footer->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật footer thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('footer.index');
    }

    public function destroy($id)
    {
        $footer = Footer::findOrFail($id);
        if($footer->delete()){
            request()->session()->flash('success','Xóa footer thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('footer.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Footer::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

use App\Models\Feature;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('id', 'desc')->paginate(20);
        return view('admin.feature.index', compact('features'));
    }

    public function create()
    {
        return view('admin.feature.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data  = $request->all();

        if(Feature::create($data)){
            request()->session()->flash('success', 'Thêm nổi bật thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('feature.index');

    }

    public function edit($id)
    {
        $feature = Feature::find($id);
        return view('admin.feature.edit', compact('feature'));
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();

        if($feature->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật nổi bật thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('feature.index');
    }

    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);
        if($feature->delete()){
            request()->session()->flash('success','Xóa nổi bật thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('feature.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Feature::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

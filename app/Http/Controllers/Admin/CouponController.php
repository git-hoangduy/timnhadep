<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->paginate(20);
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'value' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        $data  = $request->all();

        if(Coupon::create($data)){
            request()->session()->flash('success', 'Thêm mã giảm giá thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('coupon.index');

    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons,code,'.$id,
            'type' => 'required',
            'value' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        $data = $request->all();

        if($coupon->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật mã giảm giá thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('coupon.index');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        if($coupon->delete()){
            request()->session()->flash('success','Xóa mã giảm giá thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('coupon.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Coupon::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

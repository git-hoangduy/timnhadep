<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if (!empty($request->keyword)) {
            
            $query->where(function ($q) use ($request) {
                $q->where('order_number','LIKE','%'.$request->keyword.'%')
                ->orWhere('customer_name', 'like', '%' . $request->keyword . '%')
                ->orWhere('customer_phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('customer_email', 'like', '%' . $request->keyword . '%')
                ->orWhere('customer_address', 'like', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(20);
        return view('admin.order.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('admin.order.create', compact('customers'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_address' => 'required',
        ]);

        $data = [
            'order_number' => 1000000000000 + time(),
            'customer_id' => $request->customer_id ?? null,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_email' => $request->customer_email,
            'amount' => preg_replace('/[^0-9]/', '', $request->amount),
            'discount' => preg_replace('/[^0-9]/', '', $request->discount),
            'total' => preg_replace('/[^0-9]/', '', $request->total),
        ];

        $order = Order::create($data);

        if($data){

            if (!empty($request->id)) {
                foreach($request->id as $index => $id) {
                    $price = preg_replace('/[^0-9]/', '', $request->price[$index]);
                    $quantity = preg_replace('/[^0-9]/', '', $request->quantity[$index]);
                    $dataDetails = [
                        'order_id'   => $order->id,
                        'product_id' => $id,
                        'quantity'   => $quantity,
                        'price'      => $price,
                        'total'      => $quantity * $price,
                    ];
                    OrderDetail::create($dataDetails);
                }
            }
            request()->session()->flash('success', 'Thêm đơn hàng thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('order.index');

    }

    public function edit($id)
    {
        $order = Order::find($id);
        return view('admin.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $this->validate($request, [
            'status' => 'required',
        ]);

        $data = $request->all();

        if($order->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật đơn hàng thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('order.index');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        if($page->delete()){
            request()->session()->flash('success','Xóa đơn hàng thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('page.index');
    }
}

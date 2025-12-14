<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('name','LIKE','%'.$request->keyword.'%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone_extra', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%');
            });
        }

        $customers = $query->orderBy('id', 'desc')->paginate(20);

        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'phone'   => 'required',
        ]);

        $data  = $request->all();

        if(Customer::create($data)){
            request()->session()->flash('success', 'Thêm khách hàng thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('customer.index');

    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $this->validate($request, [
            'name'    => 'required',
            'phone'   => 'required',
        ]);

        $data = $request->all();

        if($customer->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật khách hàng thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('customer.index');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if($customer->delete()){
            request()->session()->flash('success','Xóa khách hàng thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('customer.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Customer::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }

    public function searchCustomer(Request $request) {

        $result['status'] = 'error';

        if ($request->search) {
            $query = Customer::query();
            $query->where(function ($q) use ($request) {
                $q->where('name', "like", "%" . $request->search . "%");
                $q->orWhere('phone', "like", "%" . $request->search . "%");
                $q->orWhere('email', "like", "%" . $request->search . "%");
                $q->orWhere('phone_extra', "like", "%" . $request->search . "%");
            });
            $customers = $query->selectRaw('id, name as text')->limit(10)->get();
            if ($customers->count()) {
                $result['status'] = 'success';
                $result['data'] = $customers;
            }
        }

        return response()->json($result);
    }

    public function getCustomer(Request $request) {

        $result['status'] = 'error';

        $customer = Customer::find($request->customerId);
        if (!empty($customer)) {
            $result['status'] = 'success';
            $result['data'] = $customer;
        }

        return response()->json($result);
    }
}

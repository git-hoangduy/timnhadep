<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Models\Bank;

class BankController extends Controller
{
    private $PATH_IMAGE = 'uploads/banks/';

    public function index()
    {
        $banks = Bank::orderBy('id', 'desc')->get();
        return view('admin.bank.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.bank.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_name'   => 'required',
            'account_number' => 'required',
            'bank_name'      => 'required',
            'bank_address'   => 'required',
            'status'         => 'required',
        ]);

        $data = $request->all();

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['account_number']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        } else {
            $data['image'] = null;
        }

        if(Bank::create($data)){
            request()->session()->flash('success', 'Thêm tài khoản ngân hàng thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('bank.index');

    }

    public function edit($id)
    {
        $bank = Bank::find($id);
        return view('admin.bank.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $this->validate($request, [
            'account_name'   => 'required',
            'account_number' => 'required',
            'bank_name'      => 'required',
            'bank_address'   => 'required',
            'status'         => 'required',
        ]);

        $data  = $request->all();

        if($request->hasFile('image')) {

            if ($bank->image != '') {
                if(File::exists($bank->image)){
                    File::delete($bank->image);
                }
            }

            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['account_number']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        }

        if($bank->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật tài khoản ngân hàng thành công');
        }
        else{
            if(File::exists($data['image'])){
                File::delete($data['image']);
            }
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('bank.index');
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        
        $image = $bank->image;

        if($bank->delete()){

            if(File::exists($image)){
                File::delete($image);
            }

            request()->session()->flash('success','Xóa tài khoản ngân hàng thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }

        return redirect()->route('bank.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Bank::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

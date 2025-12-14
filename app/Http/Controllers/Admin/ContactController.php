<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('name','LIKE','%'.$request->keyword.'%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('content', 'like', '%' . $request->keyword . '%');
            });
        }

        $contacts = $query->orderBy('id', 'desc')->paginate(20);
        return view('admin.contact.index', compact('contacts'));
    }

    public function edit($id)
    {
        $contact = Contact::find($id);
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $this->validate($request, [
            'status' => 'required',
        ]);

        $data = $request->all();

        if($contact->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật yêu cầu thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('contact.index');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        if($contact->delete()){
            request()->session()->flash('success','Xóa yêu cầu thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('contact.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Contact::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

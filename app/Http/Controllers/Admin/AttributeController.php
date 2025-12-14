<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeController extends Controller
{

    public function index()
    {
        $attributes = Attribute::orderBy('id', 'desc')->paginate(20);
        return view('admin.attribute.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attribute.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'type'   => 'required',
            'status' => 'required',
        ]);

        $data  = [
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ];

        $slug  = Str::slug($data['name']);
        $check = Attribute::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        $attribute = Attribute::create($data);
        if ($attribute) {

            $countValues = @count($request->text);
            if ($countValues) {
                for ($i = 0; $i < $countValues; $i++) {
                    $valueId = $request->id[$i] ?? null;
                    $valueText = trim($request->text[$i] ?? '');
                    $valueColor = trim($request->color[$i] ?? '');

                    if ($valueText != '') {
                        AttributeValue::updateOrCreate([
                            'id' => $valueId
                        ], [
                            'attribute_id' => $attribute->id,
                            'text' => $valueText, 
                            'color' => $valueColor
                        ]);
                    }   
                }
            }

            request()->session()->flash('success', 'Thêm thuộc tính sản phẩm thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('attribute.index');

    }

    public function edit($id)
    {
        $attribute = Attribute::find($id);
        $values = AttributeValue::where('attribute_id', $id)->get();
        return view('admin.attribute.edit', compact('attribute', 'values'));
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $this->validate($request, [
            'name'   => 'required',
            'type'   => 'required',
            'status' => 'required',
        ]);

        $data  = [
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ];
        $slug  = Str::slug($data['name']);
        $check = Attribute::where('slug', $slug)->where('id', '!=', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($attribute->fill($data)->save()){

            $countValues = @count($request->text);
            if ($countValues) {
                for ($i = 0; $i < $countValues; $i++) {
                    $valueId = $request->id[$i] ?? null;
                    $valueText = trim($request->text[$i] ?? '');
                    $valueColor = trim($request->color[$i] ?? '');

                    if ($valueText != '') {
                        $value = AttributeValue::find($valueId);
                        if (!empty($value)) {
                            $value->update([
                                'attribute_id' => $id,
                                'text' => $valueText, 
                                'color' => $valueColor
                            ]);
                        } else {
                            $value = AttributeValue::create([
                                'attribute_id' => $id,
                                'text' => $valueText, 
                                'color' => $valueColor
                            ]);
                        }
                    }   
                }
            }

            $removeValueIds = array_filter(explode(",", $request->removeValueIds));
            if (!empty($removeValueIds)) {
                AttributeValue::whereIn('id', $removeValueIds)->delete();
            }

            request()->session()->flash('success', 'Cập nhật thuộc tính sản phẩm thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('attribute.index');
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        
        if($attribute->delete()){
            AttributeValue::where('attribute_id', $id)->delete();
            request()->session()->flash('success','Xóa thuộc tính thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('attribute.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Attribute::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

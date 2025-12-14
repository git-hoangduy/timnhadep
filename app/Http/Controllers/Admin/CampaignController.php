<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::orderBy('id', 'desc')->paginate(20);
        return view('admin.campaign.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaign.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'content'   => 'nullable',
        ]);

        $data = $request->all();
        $slug  = Str::slug($data['name']);
        $check = Campaign::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if (Campaign::create($data)) {
            request()->session()->flash('success', 'Thêm chiến dịch thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('campaign.index');

    }

    public function edit($id)
    {
        $campaign = Campaign::find($id);
        return view('admin.campaign.edit', compact('campaign'));
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $this->validate($request, [
            'name'    => 'required',
            'content'   => 'nullable',
        ]);

        $data = $request->all();
        $slug  = Str::slug($data['name']);
        $check = Campaign::where(['slug' => $slug])->where('id', '<>', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($campaign->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật chiến dịch thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('campaign.index');
    }

    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        if($campaign->delete()){
            request()->session()->flash('success','Xóa chiến dịch thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('campaign.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Campaign::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

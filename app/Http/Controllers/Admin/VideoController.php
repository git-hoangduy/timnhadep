<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->paginate(20);
        return view('admin.video.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.video.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'link' => 'required|url',
        ]);

        $data = $request->all();
        $slug  = Str::slug($data['name']);
        $check = Video::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->link, $match);
        if (!empty($match[1])) {
            $data['video_id'] = $match[1];
        }

        if(Video::create($data)){
            request()->session()->flash('success', 'Thêm video thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('video.index');

    }

    public function edit($id)
    {
        $video = Video::find($id);
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'link' => 'required|url',
        ]);

        $data = $request->all();
        $slug  = Str::slug($data['name']);
        $check = Video::where(['slug' => $slug])->where('id', '<>', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->link, $match);
        if (!empty($match[1])) {
            $data['video_id'] = $match[1];
        }

        if($video->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật video thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('video.index');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        if($video->delete()){
            request()->session()->flash('success','Xóa video thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('video.index');
    }
}

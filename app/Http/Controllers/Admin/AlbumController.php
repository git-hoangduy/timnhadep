<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Models\Album;
use App\Models\AlbumImage;

class AlbumController extends Controller
{
    private $PATH_IMAGE = 'uploads/albums/';

    public function index()
    {
        $albums = Album::orderBy('id', 'desc')->paginate(20);
        return view('admin.album.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.album.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'content' => $request->content,
            'status' => $request->status,
        ];
        $slug  = Str::slug($data['name']);
        $check = Album::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        $album = Album::create($data);
        if($album){

            if($request->hasFile('images')) {
                foreach($request->file('images') as $key => $file){
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = $file->getClientOriginalName();
                    $fileNameHash = md5(time().$data['slug'].$key).'.'.$fileExtension;
                    $file->move($this->PATH_IMAGE, $fileNameHash);
                    AlbumImage::create([
                        'album_id' => $album->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName,
                    ]);
                }
            }

            if (!empty($request->is_avatar)) {
                AlbumImage::where(['album_id' => $album->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            request()->session()->flash('success', 'Thêm album thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('album.index');

    }

    public function edit($id)
    {
        $album = Album::find($id);
        return view('admin.album.edit', compact('album'));
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'content' => $request->content,
            'status' => $request->status,
        ];
        $slug  = Str::slug($data['name']);
        $check = Album::where(['slug' => $slug])->where('id', '<>', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($album->fill($data)->save()){

            if (!empty($request->removeImages)) {
                $removeImages = array_filter(explode(',', $request->removeImages));
                $productImages = AlbumImage::whereIn('id', $removeImages)->get();
                foreach($productImages as $image) {
                    if(File::exists($image->image)){
                        File::delete($image->image);
                    }
                    $image->delete();
                }
                
            }

            if ($request->hasFile('images')) {

                foreach($request->file('images') as $key => $file){
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = $file->getClientOriginalName();
                    $fileNameHash = md5(time().$data['slug'].$key).'.'.$fileExtension;
                    $file->move($this->PATH_IMAGE, $fileNameHash);

                    AlbumImage::create([
                        'album_id' => $album->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName
                    ]);
                }
            }

            if (!empty($request->is_avatar)) {
                AlbumImage::where(['album_id' => $album->id])->update(['is_avatar' => 0]);
                AlbumImage::where(['album_id' => $album->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            request()->session()->flash('success', 'Cập nhật album thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('album.index');
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        if($album->delete()){

            $images = AlbumImage::where('album_id', $id)->get();
            if ($images->count()) {
                foreach($images as $image) {
                    if(File::exists($image->image)){
                        File::delete($image->image);
                    }
                    $image->delete();
                }
            }

            request()->session()->flash('success','Xóa album thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('album.index');
    }
}

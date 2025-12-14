<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Models\Page;
use App\Models\PageImage;
use App\Models\PageBlock;
use App\Models\PageCategory;

class PageController extends Controller
{
    private $PATH_IMAGE = 'uploads/pages/';

    public function index(Request $request)
    {
        $query = Page::query();

        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('name','LIKE','%'.$request->keyword.'%')
                ->orWhere('meta_keywords', 'like', '%' . $request->keyword . '%')
                ->orWhere('meta_description', 'like', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $pages = $query->orderBy('id', 'desc')->paginate(20);
        $categories = PageCategory::where(['status' => 1, 'level' => 1])->get();

        return view('admin.page.index', compact('pages', 'categories'));
    }

    public function create()
    {
        $categories = PageCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.page.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'status' => $request->status,
        ];
        $slug  = Str::slug($data['name']);
        $check = Page::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        $page = Page::create($data);

        if($page){

            if($request->hasFile('images')) {

                foreach($request->file('images') as $key => $file){
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = $file->getClientOriginalName();
                    $fileNameHash = md5(time().$data['slug'].$key).'.'.$fileExtension;
                    $file->move($this->PATH_IMAGE, $fileNameHash);
                    PageImage::create([
                        'page_id' => $page->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName,
                    ]);
                }

                if (!empty($request->is_avatar)) {
                    PageImage::where(['page_id' => $page->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
                }
            }

            if (!empty($request->block_content)) {

                foreach($request->block_content as $key => $block_content) {
    
                    $pageBlock = PageBlock::create([
                        'page_id' => $page->id,
                        'block_content' => $block_content,
                    ]);
    
                    if (!empty($pageBlock)) {
    
                        if ($request->hasFile("block_image.{$key}")) {
                            $file = $request->file("block_image.{$key}");
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$pageBlock->id.$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
        
                            $pageBlock->block_image = $this->PATH_IMAGE.$fileName;
                            $pageBlock->save();
                        }
                    }
                }
            }

            request()->session()->flash('success', 'Thêm trang thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('page.index');

    }

    public function edit($id)
    {
        $page = Page::find($id);
        $categories = PageCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.page.edit', compact('page', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'status' => $request->status,
        ];
        
        $slug  = Str::slug($data['name']);
        $check = Page::where(['slug' => $slug])->where('id', '<>', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($page->fill($data)->save()){

            if (!empty($request->removeImages)) {
                $removeImages = array_filter(explode(',', $request->removeImages));
                $pageImages = PageImage::whereIn('id', $removeImages)->get();
                foreach($pageImages as $image) {
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

                    PageImage::create([
                        'page_id' => $page->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName
                    ]);
                }
            }

            if (!empty($request->is_avatar)) {
                PageImage::where(['page_id' => $page->id])->update(['is_avatar' => 0]);
                PageImage::where(['page_id' => $page->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            if (!empty($request->removeBlocks)) {
                $removeBlocks = array_filter(explode(',', $request->removeBlocks));
                foreach($removeBlocks as $removeBlockId) {
                    $pageBlock = PageBlock::find($removeBlockId);
                    if(File::exists($pageBlock->block_image)){
                        File::delete($pageBlock->block_image);
                    }
                    $pageBlock->delete();
                }
            }

            if (!empty($request->block_content)) {

                foreach($request->block_content as $key => $block_content) {

                    if ($request->block_id[$key] != '') {

                        $pageBlock = PageBlock::find($request->block_id[$key]);
                        $pageBlock->block_content = $block_content;
                        $pageBlock->save();

                    } else {
                        $pageBlock = PageBlock::create([
                            'page_id' => $page->id,
                            'block_content' => $block_content,
                        ]);

                    }
    
                    if (!empty($pageBlock)) {
                        if ($request->hasFile("block_image.{$key}")) {

                            if ($pageBlock->block_image != '') {
                                if(File::exists($pageBlock->block_image)){
                                    File::delete($pageBlock->block_image);
                                }
                            }

                            $file = $request->file("block_image.{$key}");
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$pageBlock->id.$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
        
                            $pageBlock->block_image = $this->PATH_IMAGE.$fileName;
                            $pageBlock->save();
                        }
                    }
                }
            }

            request()->session()->flash('success', 'Cập nhật trang thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('page.index');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        if($page->delete()){

            $pageBlocks = PageBlock::where('page_id', $id)->get();
            foreach($pageBlocks as $pageBlock) {
                if(File::exists($pageBlock->block_image)){
                    File::delete($pageBlock->block_image);
                }
                $pageBlock->delete();
            }

            request()->session()->flash('success','Xóa trang thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('page.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Page::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

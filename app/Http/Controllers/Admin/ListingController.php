<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Carbon\Carbon;

use App\Models\Listing;
use App\Models\ListingCategory;
use App\Models\ListingImage;

class ListingController extends Controller
{
    private $PATH_IMAGE = 'uploads/listing/';

    public function index(Request $request)
    {
        $query = Listing::query();

        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('name','LIKE','%'.$request->keyword.'%')
                ->orWhere('content', 'like', '%' . $request->keyword . '%')
                ->orWhere('meta_keywords', 'like', '%' . $request->keyword . '%')
                ->orWhere('meta_description', 'like', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $listings = $query->orderBy('id', 'desc')->paginate(20);
        $categories = ListingCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.listing.index', compact('listings', 'categories'));
    }

    public function create()
    {
        $categories = ListingCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.listing.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data = [
            "category_id" => $request->category_id,
            "name" => $request->name,
            "excerpt" => $request->excerpt,
            "content" => $request->content,
            "meta_keywords" => $request->meta_keywords,
            "meta_description" => $request->meta_description,
            "status" => $request->status
        ];

        $slug  = Str::slug($data['name']);
        $check = Listing::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['slug']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        } else {
            $data['image'] = null;
        }

        if (!empty($request->public_at)) {
            $date = Carbon::createFromFormat('d/m/Y H:i:s', $request->public_at);
            $data['public_at'] = $date->format('Y-m-d H:i:s');
        } else {
            $data['public_at'] = date('Y-m-d H:i:s');
        }

        $listing = Listing::create($data);
        if ($listing) {

            if (!empty($request->is_avatar)) {
                ListingImage::where(['listing_id' => $listing->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            request()->session()->flash('success', 'Thêm tin mua bán thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('listing.index');

    }

    public function edit($id)
    {
        $categories = ListingCategory::where(['status' => 1, 'level' => 1])->get();
        $listing = Listing::find($id);
        return view('admin.listing.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data = [
            "category_id" => $request->category_id,
            "name" => $request->name,
            "excerpt" => $request->excerpt,
            "content" => $request->content,
            "meta_keywords" => $request->meta_keywords,
            "meta_description" => $request->meta_description,
            "status" => $request->status
        ];
        
        $slug  = Str::slug($data['name']);
        $check = Listing::where('slug', $slug)->where('id', '!=', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($request->hasFile('image')) {

            if ($listing->image != '') {
                if(File::exists($listing->image)){
                    File::delete($listing->image);
                }
            }

            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time().$data['slug']).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        }

        if (!empty($request->public_at)) {
            $date = Carbon::createFromFormat('d/m/Y H:i:s', $request->public_at);
            $data['public_at'] = $date->format('Y-m-d H:i:s');
        } else {
            $data['public_at'] = date('Y-m-d H:i:s');
        }

        if($listing->fill($data)->save()){
            
            request()->session()->flash('success', 'Cập nhật tin mua bán thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('listing.index');
    }

    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        if($listing->delete()){

            // $images = ListingImage::where('listing_id', $id)->get();
            // if ($images->count()) {
            //     foreach($images as $image) {
            //         if(File::exists($image->image)){
            //             File::delete($image->image);
            //         }
            //         $image->delete();
            //     }
            // }

            request()->session()->flash('success','Xóa tin mua bán thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('listing.index');
    }

    public function isHighlight(Request $request) {
        $listing = Listing::where('id', $request->id)->first();
        \DB::table('listings')->where('id', $request->id)->update([
            'is_highlight' => $request->status, 
            'updated_at' => $listing->updated_at
        ]);
        return response()->json(['success' => true]);
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Listing::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:listings,id'
        ]);

        $listing = Listing::findOrFail($request->id);
        
        $listing->status = Listing::STATUS_ACTIVE;
        
        if (!$listing->public_at) {
            $listing->public_at = now();
        }
        
        $listing->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã duyệt tin đăng thành công!',
            'listing' => $listing
        ]);
    }
}

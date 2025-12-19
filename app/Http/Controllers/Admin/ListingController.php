<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
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
        // Validation (tương tự user nhưng có thể thêm fields)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:listing_categories,id',
            'type' => 'required|in:sale,rent,buy,rental',
            'price' => 'required|string|max:100',
            'area' => 'required|string|max:50',
            'location' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:0,1,2,3',
            'is_highlight' => 'nullable|boolean',
        ]);
        
        // Xử lý lưu (tương tự user nhưng không có customer_id)
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Listing::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $excerpt = $request->excerpt ?: Str::limit(strip_tags($request->content), 200);
        
        // Tạo listing - KHÔNG có customer_id vì admin đăng
        $listing = Listing::create([
            'category_id' => $request->category_id,
            'type' => $request->type,
            'name' => $request->name,
            'slug' => $slug,
            'excerpt' => $excerpt,
            'content' => $request->content,
            'status' => $request->status,
            'is_highlight' => $request->is_highlight ?? 0,
            'price' => $request->price,
            'area' => $request->area,
            'location' => $request->location,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            // KHÔNG có customer_id, customer_name, customer_phone, customer_email
            'public_at' => $request->public_at ? Carbon::createFromFormat('d/m/Y H:i:s', $request->public_at) : now(),
        ]);

        if($request->hasFile('images')) {

            foreach($request->file('images') as $key => $file){
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = $file->getClientOriginalName();
                $fileNameHash = md5(time().$slug.$key).'.'.$fileExtension;
                $file->move($this->PATH_IMAGE, $fileNameHash);
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image' => $this->PATH_IMAGE.$fileNameHash,
                    'name' => $fileName,
                ]);
            }

            if (!empty($request->is_avatar)) {
                ListingImage::where(['listing_id' => $listing->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }
        }
        
        return redirect()->route('listing.index')->with('success', 'Đã tạo tin đăng thành công!');
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
        
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:listing_categories,id',
            'type' => 'required|in:sale,rent,buy,rental',
            'price' => 'required|string|max:100',
            'area' => 'required|string|max:50',
            'location' => 'required|string|max:500',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:0,1,2,3',
            'is_highlight' => 'nullable|boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Cập nhật slug nếu tiêu đề thay đổi
        $slug = $listing->slug;
        if ($listing->name != $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Listing::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }
        
        $excerpt = $request->excerpt ?: Str::limit(strip_tags($request->content), 200);
        
        // Cập nhật listing
        $listing->update([
            'category_id' => $request->category_id,
            'type' => $request->type,
            'name' => $request->name,
            'slug' => $slug,
            'excerpt' => $excerpt,
            'content' => $request->content,
            'status' => $request->status,
            'is_highlight' => $request->is_highlight ?? 0,
            'price' => $request->price,
            'area' => $request->area,
            'location' => $request->location,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'public_at' => $request->public_at ? Carbon::createFromFormat('d/m/Y H:i:s', $request->public_at) : $listing->public_at,
        ]);
        
        // Xử lý xóa ảnh nếu có
        if (!empty($request->removeImages)) {
            $removeImages = array_filter(explode(',', $request->removeImages));
            $imagesToDelete = ListingImage::whereIn('id', $removeImages)->get();
            
            foreach($imagesToDelete as $image) {
                // Xóa file vật lý
                if(File::exists(public_path($image->image))) {
                    File::delete(public_path($image->image));
                }
                $image->delete();
            }
        }
        
        // Xử lý upload ảnh mới
        if($request->hasFile('images')) {
            foreach($request->file('images') as $key => $file) {
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = $file->getClientOriginalName();
                $fileNameHash = md5(time().$slug.$key).'.'.$fileExtension;
                $file->move($this->PATH_IMAGE, $fileNameHash);
                
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image' => $this->PATH_IMAGE.$fileNameHash,
                    'name' => $fileName,
                    'is_avatar' => 0,
                ]);
            }
        }
        
        // Cập nhật ảnh đại diện
        if (!empty($request->is_avatar)) {
            // Reset tất cả ảnh về không phải đại diện
            ListingImage::where('listing_id', $listing->id)->update(['is_avatar' => 0]);
            
            // Set ảnh đại diện mới
            $avatarImage = ListingImage::where([
                'listing_id' => $listing->id,
                'name' => $request->is_avatar
            ])->first();
            
            if ($avatarImage) {
                $avatarImage->update(['is_avatar' => 1]);
                // Cập nhật ảnh đại diện cho listing
                $listing->update(['image' => $avatarImage->image]);
            }
        }
        
        return redirect()->route('listing.index')
            ->with('success', 'Cập nhật tin đăng thành công!');
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

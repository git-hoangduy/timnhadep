<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Carbon\Carbon;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostImage;
use App\Models\Tag;

class PostController extends Controller
{
    private $PATH_IMAGE = 'uploads/posts/';

    public function index(Request $request)
    {
        $query = Post::query();

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

        $posts = $query->orderBy('id', 'desc')->paginate(20);
        $categories = PostCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.post.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = PostCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.post.create', compact('categories'));
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
        $check = Post::where('slug', $slug)->first();
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

        $post = Post::create($data);
        if ($post) {

            $this->syncTags($post, $request->tags);

            if (!empty($request->is_avatar)) {
                PostImage::where(['post_id' => $post->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            request()->session()->flash('success', 'Thêm bài viết thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('post.index');

    }

    public function edit($id)
    {
        $categories = PostCategory::where(['status' => 1, 'level' => 1])->get();
        $post = Post::with('tags')->find($id);
        return view('admin.post.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

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
        $check = Post::where('slug', $slug)->where('id', '!=', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($request->hasFile('image')) {

            if ($post->image != '') {
                if(File::exists($post->image)){
                    File::delete($post->image);
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

        if($post->fill($data)->save()){

            $this->syncTags($post, $request->tags);
            
            request()->session()->flash('success', 'Cập nhật bài viết thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('post.index');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->delete()){

            // $images = PostImage::where('post_id', $id)->get();
            // if ($images->count()) {
            //     foreach($images as $image) {
            //         if(File::exists($image->image)){
            //             File::delete($image->image);
            //         }
            //         $image->delete();
            //     }
            // }

            request()->session()->flash('success','Xóa bài viết thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('post.index');
    }

    public function isHighlight(Request $request) {
        $post = Post::where('id', $request->id)->first();
        \DB::table('posts')->where('id', $request->id)->update([
            'is_highlight' => $request->status, 
            'updated_at' => $post->updated_at
        ]);
        return response()->json(['success' => true]);
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Post::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }

    private function syncTags($post, $tagsString)
    {
        if (empty($tagsString)) {
            // Xóa tất cả tags của bài viết này
            Tag::where('post_id', $post->id)
               ->where('type', 'post')
               ->delete();
            return;
        }

        // Tách tags bằng dấu phẩy
        $tagsArray = explode(',', $tagsString);
        $tagsArray = array_map('trim', $tagsArray);
        $tagsArray = array_filter($tagsArray); // Loại bỏ giá trị rỗng
        $tagsArray = array_unique($tagsArray); // Loại bỏ trùng lặp

        // Xóa tags cũ của bài viết này
        Tag::where('post_id', $post->id)
           ->where('type', 'post')
           ->delete();
        
        // Thêm tags mới
        foreach ($tagsArray as $tagName) {
            if (empty($tagName)) continue;
            
            // Tạo slug từ tag name
            $tagSlug = Str::slug($tagName);
            
            // Tạo tag mới
            Tag::create([
                'name' => $tagName,
                'slug' => $tagSlug,
                'type' => 'post',
                'post_id' => $post->id,
                'project_id' => null,
            ]);
        }
    }

    // THÊM PHƯƠNG THỨC LẤY BÀI VIẾT LIÊN QUAN
    public function getRelatedPosts($postId, $limit = 5)
    {
        $post = Post::with('tags')->find($postId);
        
        if (!$post || $post->tags->isEmpty()) {
            return collect();
        }
        
        // Lấy tất cả tag names của bài viết
        $tagNames = $post->tags->pluck('name')->toArray();
        
        // Lấy các tag IDs từ tag names
        $tagIds = Tag::whereIn('name', $tagNames)
                     ->where('type', 'post')
                     ->where('post_id', '!=', $postId)
                     ->pluck('post_id')
                     ->toArray();
        
        // Lấy bài viết có chung tag (trừ bài viết hiện tại)
        $relatedPosts = Post::whereIn('id', $tagIds)
            ->where('status', 1)
            ->where('id', '!=', $postId)
            ->orderBy('public_at', 'desc')
            ->limit($limit)
            ->get();
        
        return $relatedPosts;
    }
}

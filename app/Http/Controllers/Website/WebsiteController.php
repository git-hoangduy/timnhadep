<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

use App\Models\Contact;
use App\Models\Page;
use App\Models\Project;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\ProjectCategory;
use App\Models\Album;
use App\Models\Listing;
use App\Models\ListingCategory;

class WebsiteController extends Controller
{
    public function __construct() {
        // Default seo meta
        SEOMeta::addKeyword(setting('seo.meta_keywords'));
        SEOMeta::setDescription(setting('seo.meta_description'));  
    }

    public function index() {
        $page = Page::find(1);
        $projects = Project::where('status', 1)->orderBy('id', 'desc')->limit(3)->get();
        $posts = Post::where('status', 1)->orderBy('id', 'desc')->limit(3)->get();
        $listings = Listing::with(['category', 'customer'])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        SEOMeta::setTitle('Trang chủ');
        OpenGraph::setUrl(url()->current());
        OpenGraph::setDescription(setting('seo.meta_description'));
        OpenGraph::addImage(asset(setting('seo.ogimage')), ['height' => 300, 'width' => 300]);
        return view('website.index', compact('page', 'projects', 'posts', 'listings'));
    }


    public function page($slug) {

        $page = Page::where('slug', $slug)->first();
        SEOMeta::setTitle($page->name);
        OpenGraph::setTitle($page->name);
        OpenGraph::addImage(asset(setting('seo.ogimage')), ['height' => 300, 'width' => 300]);

        return view('website.page', compact('page'));
    }

    public function post(Request $request, $slug = '') {
        $category = PostCategory::where(['slug' => $slug])->first();

        $query = Post::query();
        $query->where('status', 1);
        $query->where('public_at', '<=' , date('Y-m-d H:i:s'));
        
        if (!empty($category)) {
            $cateIds = $category->childrenIds();
            $query->whereIn('category_id', $cateIds)->where('status', 1);
        }

        $posts = $query->orderBy('is_highlight', 'desc')->orderBy('id', 'desc')->paginate(16);

        if (!empty($category)) {
            SEOMeta::setTitle($category->name);
            OpenGraph::setTitle($category->name);
        } else {
            SEOMeta::setTitle('Tất cả bài viết');
            OpenGraph::setTitle('Tất cả bài viết');
        }
        
        OpenGraph::addImage(asset(setting('seo.ogimage')), ['height' => 300, 'width' => 300]);

        return view('website.post', compact('posts', 'category'));
    }

    public function project(Request $request, $slug = '') {
        $category = ProjectCategory::where(['slug' => $slug])->first();

        $query = Project::query();
        $query->where('status', 1);
        
        if (!empty($category)) {
            $cateIds = $category->childrenIds();
            $query->whereIn('category_id', $cateIds)->where('status', 1);
        }

        $projects = $query->orderBy('id', 'desc')->paginate(12);

        if (!empty($category)) {
            SEOMeta::setTitle($category->name);
            OpenGraph::setTitle($category->name);
        } else {
            SEOMeta::setTitle('Tất cả dự án');
            OpenGraph::setTitle('Tất cả dự án');
        }
        
        OpenGraph::addImage(asset(setting('seo.ogimage')), ['height' => 300, 'width' => 300]);

        return view('website.project', compact('projects', 'category'));
    }

    public function postDetail(Request $request, $slug = '') {

        $post = Post::where('slug', $slug)->first();

        $recentPosts = Post::where('id', '<>', $post->id)->where('status', 1)->where('public_at', '<=' , date('Y-m-d H:i:s'))->where('category_id', $post->category_id)->limit(8)->get();

        SEOMeta::setTitle($post->name);
        OpenGraph::setTitle($post->name);
        OpenGraph::addImage(asset($post->image), ['height' => 300, 'width' => 300]);
        return view('website.post-detail', compact('post', 'recentPosts'));
    }

    public function listingDetail(Request $request, $slug = '') {

        $listing = Listing::where('slug', $slug)->first();

        SEOMeta::setTitle($listing->name);
        OpenGraph::setTitle($listing->name);
        OpenGraph::addImage(asset($listing->image), ['height' => 300, 'width' => 300]);
        return view('website.listing-detail', compact('listing'));
    }

    public function contact(Request $request) {

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'parent_name'    => 'required',
                'parent_phone'   => 'required',
                'age'   => 'required',
                'branch' => 'required',
            ],);

            $data = $request->all();
            if (Contact::create($data)) {
                request()->session()->flash('success', 'Gửi yêu cầu thành công');
            }
            else{
                request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
            }

            return redirect()->back();
        }

        SEOMeta::setTitle('Liên hệ');
        OpenGraph::setTitle('Liên hệ');
        OpenGraph::addImage(asset(setting('seo.ogimage')), ['height' => 300, 'width' => 300]);

        return view('website.contact');  
    }

    public function sitemap($value='')
    {
        $posts = Post::latest()->where('status', 1)->where('public_at', '<=' , date('Y-m-d H:i:s'))->get();
        $pages = Page::latest()->where('status', 1)->get();

        return response()->view('website.sitemap', [
            'posts' => $posts,
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }
}

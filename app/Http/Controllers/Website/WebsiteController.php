<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $projects = Project::where('status', 1)->orderBy('is_highlight', 'desc')->orderBy('id', 'desc')->limit(6)->get();
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

        $projects = $query->orderBy('is_highlight', 'desc')->orderBy('id', 'desc')->paginate(12);

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

    // public function projectDetail(Request $request, $slug = '') {

    //     $project = Project::where('slug', $slug)->first();
    //     $recentPosts = Post::where('status', 1)->where('public_at', '<=' , date('Y-m-d H:i:s'))->limit(3)->get();

    //     SEOMeta::setTitle($project->name);
    //     OpenGraph::setTitle($project->name);
    //     OpenGraph::addImage(asset($project->image), ['height' => 300, 'width' => 300]);
    //     return view('website.project-detail', compact('project', 'recentPosts'));
    // }

    public function projectDetail(Request $request, $slug = '') {
        $project = Project::where('slug', $slug)->first();
        
        if (!$project) {
            abort(404);
        }
    
        // Lấy nội dung project để so sánh
        $projectText = '';
        if (!empty($project->name)) $projectText .= ' ' . $project->name;
        // if (!empty($project->slogan)) $projectText .= ' ' . $project->slogan;
        // if (!empty($project->excerpt)) $projectText .= ' ' . $project->excerpt;
        
        // Lấy tất cả tags có name trùng với nội dung project
        $matchedTags = \App\Models\Tag::where(function($query) use ($projectText) {
            // Tìm tag có trong nội dung project
            $query->whereRaw('? LIKE CONCAT("%", name, "%")', [$projectText]);
        })->pluck('name')->toArray();
        
        // Nếu có tags trùng
        if (!empty($matchedTags)) {
            // Lấy bài viết có chứa các tags này
            $recentPosts = Post::where('status', 1)
                              ->where('public_at', '<=', date('Y-m-d H:i:s'))
                              ->whereHas('tags', function($query) use ($matchedTags) {
                                  $query->whereIn('name', $matchedTags);
                              })
                              ->orderBy('public_at', 'desc')
                              ->limit(3)
                              ->get();
        } else {
            // Không có tag trùng, lấy từ khóa từ nội dung project
            $words = explode(' ', $projectText);
            $keywords = [];
            foreach ($words as $word) {
                $word = trim($word);
                if (strlen($word) >= 3) {
                    $keywords[] = $word;
                }
            }
            $keywords = array_unique($keywords);
            
            $recentPosts = Post::where('status', 1)
                              ->where('public_at', '<=', date('Y-m-d H:i:s'))
                              ->where(function($query) use ($keywords) {
                                  foreach ($keywords as $keyword) {
                                      $query->orWhere('name', 'LIKE', '%' . $keyword . '%')
                                            ->orWhere('excerpt', 'LIKE', '%' . $keyword . '%')
                                            ->orWhere('meta_keywords', 'LIKE', '%' . $keyword . '%');
                                  }
                              })
                              ->orderBy('public_at', 'desc')
                              ->limit(3)
                              ->get();
        }
    
        SEOMeta::setTitle($project->name ?: $project->slogan);
        OpenGraph::setTitle($project->name ?: $project->slogan);
        if ($project->image) {
            OpenGraph::addImage(asset($project->image), ['height' => 300, 'width' => 300]);
        }
        
        return view('website.project-detail', compact('project', 'recentPosts'));
    }

    public function postDetail(Request $request, $slug = '') {

        $post = Post::where('slug', $slug)->first();

        $recentPosts = Post::where('id', '<>', $post->id)->where('status', 1)->where('public_at', '<=' , date('Y-m-d H:i:s'))->where('category_id', $post->category_id)->limit(8)->get();

        SEOMeta::setTitle($post->name);
        OpenGraph::setTitle($post->name);
        OpenGraph::addImage(asset($post->image), ['height' => 300, 'width' => 300]);
        return view('website.post-detail', compact('post', 'recentPosts'));
    }

    public function listing(Request $request, $slug = '') {

        $query = Listing::where('status', 1);
    
        // Apply filters
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->price_range) {
            // Add price range logic
        }
        
        $listings = $query->paginate(12);
        
        return view('website.listing', compact('listings'));
    }

    public function listingDetail(Request $request, $slug = '') {

        $listing = Listing::where('slug', $slug)->first();

        SEOMeta::setTitle($listing->name);
        OpenGraph::setTitle($listing->name);
        OpenGraph::addImage(asset($listing->image), ['height' => 300, 'width' => 300]);
        return view('website.listing-detail', compact('listing'));
    }

    public function contact(Request $request) {

        if ($request->ajax()) {
            $data = $request->all();
            if (Contact::create($data)) {
                // $this->sendMail([
                //     'name' => $data['name'],
                //     'email' => $data['email'] ?? '',
                //     'message' => 'Chỉ đăng ký nhận tin từ website',
                // ]);
                return response()->json(['success' => true, 'message' => 'Gửi yêu cầu thành công']);
            }
            else{
                return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi, xin hãy thử lại!']);
            }
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name'    => 'required',
                'phone'   => 'required',
                'message'   => 'required',
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

    public function sendMail($data)
    {
        try {
            $emailData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'content' => $data['message']
            ];

            Mail::send('emails.contact', $emailData, function ($message) use ($data) {
                $message->to('duynguyen.joy@gmail.com')
                        ->subject('Yêu cầu liên hệ từ website');

                $message->from(
                    config('mail.from.address'),
                    config('mail.from.name')
                );
            });

            Log::info('Mail đã gửi xong (Laravel không báo lỗi)');
        } catch (\Throwable $e) {
            Log::error('LỖI GỬI MAIL', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            dd($e->getMessage());
        }
    }

    public function sitemap($value='')
    {
        $posts = Post::latest()->where('status', 1)->where('public_at', '<=' , date('Y-m-d H:i:s'))->get();
        $pages = Page::latest()->where('status', 1)->get();
        $projects = Project::latest()->where('status', 1)->get();

        return response()->view('website.sitemap', [
            'posts' => $posts,
            'pages' => $pages,
            'projects' => $projects
        ])->header('Content-Type', 'text/xml');
    }
}

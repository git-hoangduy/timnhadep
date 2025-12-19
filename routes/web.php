<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\TinymceController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PageCategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\ListingCategoryController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\VideoController;

use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\UserController as WebsiteUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Backend routes
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/post-login', [AdminController::class, 'postLogin'])->name('admin.postLogin');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin'], function () {

    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::resourceExtend('order', OrderController::class);
    Route::resourceExtend('product', ProductController::class);
    Route::resourceExtend('product-category', ProductCategoryController::class);
    Route::resourceExtend('review', ReviewController::class);
    Route::resourceExtend('brand', BrandController::class);
    Route::resourceExtend('attribute', AttributeController::class);
    Route::resourceExtend('coupon', CouponController::class);
    Route::resourceExtend('page-category', PageCategoryController::class);
    Route::resourceExtend('page', PageController::class);
    Route::resourceExtend('banner', BannerController::class);
    Route::resourceExtend('customer', CustomerController::class);
    Route::resourceExtend('user', UserController::class);
    Route::resourceExtend('campaign', CampaignController::class);
    Route::resourceExtend('bank', BankController::class);
    Route::resourceExtend('contact', ContactController::class);
    Route::resourceExtend('post', PostController::class);
    Route::resourceExtend('post-category', PostCategoryController::class);
    Route::resourceExtend('project', ProjectController::class);
    Route::resourceExtend('project-category', ProjectCategoryController::class);
    Route::resourceExtend('listing', ListingController::class);
    Route::post('listing/approve', [ListingController::class, 'approve'])->name('listing.approve');
    Route::resourceExtend('listing-category', ListingCategoryController::class);
    Route::resourceExtend('feature', FeatureController::class);
    Route::resourceExtend('album', AlbumController::class);
    Route::resourceExtend('footer', FooterController::class);
    Route::resourceExtend('video', VideoController::class);

    Route::match(['get', 'post'], '/setting/info', [SettingController::class, 'info'])->name('setting.info');
    Route::match(['get', 'post'], '/setting/social', [SettingController::class, 'social'])->name('setting.social');
    Route::match(['get', 'post'], '/setting/seo', [SettingController::class, 'seo'])->name('setting.seo');

    Route::get('/change-password', [AdminController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [AdminController::class, 'updatePassword'])->name('update-password');
    
    // Ajax routes
    Route::post('/post/is-highlight', [PostController::class, 'isHighlight'])->name('post.isHighlight');
    Route::post('/tinymce/upload-image', [TinymceController::class, 'uploadImage']);
});

// Frontend routes
Route::get('sitemap.xml', [WebsiteController::class, 'sitemap']);
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/lien-he', [WebsiteController::class, 'contact'])->name('contact');
Route::get('/gioi-thieu', [WebsiteController::class, 'about'])->name('about');
Route::get('/trang/{slug}', [WebsiteController::class, 'page'])->name('page');
Route::get('/danh-muc-bai-viet/{slug?}', [WebsiteController::class, 'post'])->name('post');
Route::get('/bai-viet/{slug?}', [WebsiteController::class, 'postDetail'])->name('post.detail');
Route::get('/danh-muc-du-an', [WebsiteController::class, 'project'])->name('project');
Route::get('/du-an/{slug?}', [WebsiteController::class, 'projectDetail'])->name('project.detail');
Route::get('/danh-muc-mua-ban', [WebsiteController::class, 'listing'])->name('listing');
Route::get('/danh-muc-mua-ban', [WebsiteController::class, 'listing'])->name('listing');
Route::get('/mua-ban/{slug?}', [WebsiteController::class, 'listingDetail'])->name('listing.detail');

Route::match(['get', 'post'], '/user/login', [WebsiteUserController::class, 'login'])->name('user.login');
Route::match(['get', 'post'], '/user/register', [WebsiteUserController::class, 'register'])->name('user.register');
Route::get('user/logout', [WebsiteUserController::class, 'logout'])->name('user.logout');
Route::middleware(['auth:customer'])->group(function () {

    Route::match(['get', 'post'], '/user/profile', [WebsiteUserController::class, 'profile'])->name('user.profile');
    Route::match(['get', 'post'], '/user/password', [WebsiteUserController::class, 'password'])->name('user.password');
    Route::get('/user/history', [WebsiteUserController::class, 'history'])->name('user.history');
    Route::get('/user/order', [WebsiteUserController::class, 'order'])->name('user.order');

    Route::post('/user/listings/store', [WebsiteUserController::class, 'storeListing'])->name('user.listings.store');
    Route::get('/user/my-listings', [WebsiteUserController::class, 'myListings'])->name('user.my-listings');
    Route::delete('/user/listings/{id}', [WebsiteUserController::class, 'destroyListing'])->name('user.listings.destroy');
});
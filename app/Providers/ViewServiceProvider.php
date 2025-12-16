<?php

namespace App\Providers;

use App\Models\Footer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\PageCategory;
use App\Models\PostCategory;
use App\Models\Page;
use App\Models\ListingCategory;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'website/*', 
        ], function ($view) {

            $pages = Page::where('status', 1)->get();
            $listingCategories = ListingCategory::where('status', 1)->get();

            // $pageCategories = PageCategory::where(['level' => 1, 'status' => 1])->get();
            // $postCategories = PostCategory::where(['level' => 1, 'status' => 1])->get();
            // $footers = Footer::where('status', 1)->get();
         
            // $view->with('pageCategories', $pageCategories);
            // $view->with('postCategories', $postCategories);
            // $view->with('footers', $footers);

            $view->with('pages', $pages);
            $view->with('listingCategories', $listingCategories);
        });
    }
}

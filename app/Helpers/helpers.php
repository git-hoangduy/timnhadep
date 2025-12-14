<?php

use Illuminate\Support\Facades\View;

use App\Models\Setting;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Album;
use App\Models\Review;

if (!function_exists('setting')) {
    function setting($code) {
        $path = storage_path('app/json/setting.json');
        $setting = json_decode(file_get_contents($path), true);
        return $setting[$code] ?? null;
    }
}

if (!function_exists('productCart')) {
    function productInfo($id) {
        $product = Product::find($id);
        return $product;
    }
}

if (!function_exists('attrInfo')) {
    function attrInfo($id, $valueId) {
        $attr = Attribute::find($id);
        $attrValue = AttributeValue::find($valueId);
        if (!empty($attr) && !empty($attrValue)) {
            return [
                'name' => $attr->name,
                'color' => $attrValue->color,
                'text' => $attrValue->text,
            ];
        } else {
            return null;
        }
    }
}

if (!function_exists('renderContent')) {
    function renderContent($content) {

        // Tinymce images matches
        $pattern = '/(?<!\/)uploads\/tinymce\/[^\s"\'\)]+/';
        $content = preg_replace_callback($pattern, function ($matches) {
            return '/' . $matches[0];
        }, $content);

        // Posts matches
        $pattern = '/\[FEATURED-POSTS\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $html = View::make('website/partials/featured-posts')->render();
                $content = str_replace($code, $html, $content);
            }
        }

        // Album matches
        $pattern = '/\[ALBUM-\d+\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $album = Album::where(['code' => $code, 'status' => 1])->first();
                if (!empty($album)) {
                    $html = View::make('website/partials/album', ['album' => $album])->render();
                    $content = str_replace($code, $html, $content);
                }
            }
        }

        // Reviews matches
        $pattern = '/\[REVIEWS\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $reviews = Review::where(['status' => 1])->get();
                if (!empty($reviews)) {
                    $html = View::make('website/partials/reviews', ['reviews' => $reviews])->render();
                    $content = str_replace($code, $html, $content);
                }
            }
        }

        // Socials matches
        $pattern = '/\[FACEBOOK\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $url = setting('social.facebook');
                $html = View::make("website/partials/icon/facebook", ['url' => $url])->render();
                $content = str_replace($code, $html, $content);
            }
        }

        $pattern = '/\[YOUTUBE\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $url = setting('social.youtube');
                $html = View::make("website/partials/icon/youtube", ['url' => $url])->render();
                $content = str_replace($code, $html, $content);
            }
        }

        $pattern = '/\[INSTAGRAM\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $url = setting('social.instagram');
                $html = View::make("website/partials/icon/instagram", ['url' => $url])->render();
                $content = str_replace($code, $html, $content);
            }
        }

        $pattern = '/\[TIKTOK\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $url = setting('social.tiktok');
                $html = View::make("website/partials/icon/tiktok", ['url' => $url])->render();
                $content = str_replace($code, $html, $content);
            }
        }

        $pattern = '/\[ZALO\]/'; 
        $matches = []; 
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach($matches[0] as $code) {
                $url = setting('social.zalo');
                $html = View::make("website/partials/icon/zalo", ['url' => $url])->render();
                $content = str_replace($code, $html, $content);
            }
        }

        return $content;
    }
}

const mix = require('laravel-mix');

require('laravel-mix-obfuscator');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css')
//     .sourceMaps();

// Run once time
// mix.copyDirectory('vendor/tinymce/tinymce', 'public/admin/js/tinymce');


// mix.styles([
//     'resources/website/css/style.css',
//     'resources/website/css/tinymce-template.css',    
// ], 'public/website/css/style.min.css').version();
    
mix.styles([
    'resources/website/css/tinymce-template.css',    
], 'public/website/css/tinymce-template.min.css').version();
    

mix.scripts([
    'resources/website/js/script.js', 
], 'public/website/js/script.min.js').obfuscator({}).version();
    
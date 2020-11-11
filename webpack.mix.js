const mix = require('laravel-mix');

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

//  .version()使用哈希值，每次更改都生成新的 js 或 css 文件，强令浏览刷新本地缓存
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .copyDirectory('resources/editor/js', 'public/js')
    .copyDirectory('resources/editor/css', 'public/css');

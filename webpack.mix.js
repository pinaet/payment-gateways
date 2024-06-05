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

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix
    .setResourceRoot('./'); //solve fonts not found

mix
    .js('resources/js/endpoint.js', 'public/js')
    .js('resources/js/order.js', 'public/js')
    .js('resources/js/order-result.js', 'public/js')
    .sourceMaps(false, 'source-map')

mix
    .sass('resources/sass/main.scss', 'public/css');

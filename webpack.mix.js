const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('public/css/dashboard_custom.css', 'public/css/dashboard_custom.'+ Date.now() +'.css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]).sass('pasaka_html/src/scss/main.scss', 'public/css/main.'+ Date.now()).version();

const mix = require('laravel-mix');
require('vuetifyjs-mix-extension');

Mix.manifest.name = 'mix-manifest.json';

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
 mix.setPublicPath('public')
mix.js('resources/js/app.js', '/js/app.js').vuetify('vuetify-loader').vue()
    .sass('resources/sass/app.scss', '/css/app.css')
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}

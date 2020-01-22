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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .extract([
        'jquery',
        'bootstrap',
        'popper.js',
        'lodash',
        'vue',
        'icheck-bootstrap',
    ]);

if (mix.inProduction()) {
    mix.version()
        .options({
            cache: true,
            parallel: true,
            sourceMap: true,
            processCssUrls: true
        });
} else {
    // Uses inline source-maps on development
    mix.webpackConfig({
        devtool: 'inline-source-map'
    });
}

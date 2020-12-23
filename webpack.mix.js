const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/emoji-picker.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/darkmode.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}

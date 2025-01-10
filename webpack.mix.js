const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .css('resources/css/custom_out.css', 'public/css')
    .sourceMaps()
    .autoload({
        jquery: ['$', 'window.jQuery']
    })
    .version();

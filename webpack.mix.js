const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/funcionario.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [])
    .css('resources/css/custom.css', 'public/css')
    .sourceMaps()
    .autoload({
        jquery: ['$', 'window.jQuery']
    })
    .version();

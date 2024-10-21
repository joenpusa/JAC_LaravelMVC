const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/funcionario.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [])
    .css('resources/css/custom.css', 'public/css')
    .css('resources/css/custom_out.css', 'public/css')
    .sourceMaps()
    .autoload({
        jquery: ['$', 'window.jQuery']
    })
    .version();

// mix.styles([
//     'public/assets/css/style.css',
// ], 'public/css/all.css');

// mix.scripts([
//         'public/assets/js/script.js',
//     ], 'public/js/all.js');

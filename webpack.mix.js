const mix = require('laravel-mix');

 mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js', [])
    .js('resources/js/materialize.js', 'public/js', [])
    .postCss('resources/css/materialize.css', 'public/css', [])
    .postCss('resources/css/app.css', 'public/css', []);

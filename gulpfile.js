const elixir = require('laravel-elixir');


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
    .styles([
        './bower_components/material-design-icons-iconfont/dist/material-design-icons.css',
        './bower_components/material-design-lite/material.css'
    ],'public/css/vendor.css')
    .copy([
        './resources/assets/js/templates'
    ], 'public/templates')
    .copy([
        './bower_components/material-design-icons-iconfont/dist/fonts'
    ], 'public/build/css/fonts')
    .scripts([
        './bower_components/angular/angular.js',
        './bower_components/jquery/dist/jquery.js',
        './bower_components/material-design-lite/material.js'
    ], 'public/js/vendor.js')
    .scripts([
        'app.js'
    ], 'public/js/app.js')
    .version([
        'public/css/vendor.css', 'public/js/vendor.js',
        'public/css/app.css', 'public/js/app.js'
    ]);
});

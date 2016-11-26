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
    mix.styles([
      './node_modules/bootstrap/dist/css/bootstrap-flex.css',
      './node_modules/font-awesome/css/font-awesome.css'
    ],'public/css/vendor.css')
    .scripts([
      './node_modules/jquery/dist/jquery.js',
      './node_modules/tether/dist/js/tether.js',
      './node_modules/bootstrap/dist/js/bootstrap.js',
      './node_modules/jquery-ui-dist/jquery-ui.js'
    ], 'public/js/vendor.js')
    .copy([
        './node_modules/font-awesome/fonts'
    ], 'public/fonts')
});

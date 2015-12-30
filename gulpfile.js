var elixir = require('laravel-elixir');

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

elixir.config.sourcemaps = false;

var paths = {
    'bootstrap': './vendor/thomaspark/bootswatch/bower_components/bootstrap/',
    'jquery': './vendor/thomaspark/bootswatch/bower_components/jquery/',
    'bootswatch': './vendor/thomaspark/bootswatch/',
    'bootstraptable': './vendor/wenzhixin/bootstrap-table/',
    'icheck': './vendor/fronteed/icheck/'
}

elixir(function(mix) {
    mix.less('app.less')
        .copy('resources/assets/images', 'public/images')
        .copy(paths.bootstrap + 'dist/fonts', 'public/fonts')

        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.css', 'public/css/bootstrap-table.min.css')
        .copy(paths.icheck + 'icheck.min.js', 'public/js/icheck.min.js')

        .copy(paths.jquery + "dist/jquery.min.js", 'public/js/jquery.min.js')
        .copy(paths.bootstrap + 'dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.js', 'public/js/bootstrap-table.min.js')
        .copy(paths.icheck + 'skins/flat', 'public/css/icheck')
        .scripts('app.js', 'public/js/app.min.js');
});

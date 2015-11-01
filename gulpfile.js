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
    'bootstrap': './node_modules/bootswatch/bower_components/bootstrap-sass-official/assets/',
    'jquery': './node_modules/bootswatch/bower_components/jquery/',
    'bootswatch': './node_modules/bootswatch/',
    'bootflat': './node_modules/bootflat/bootflat/',
    'bootstraptable': './node_modules/bootstrap-table/',
    'icheck': 'node_modules/icheck/'
}

elixir(function(mix) {
    mix.sass('app.scss')
        .copy(paths.bootstrap + 'fonts/bootstrap', 'public/fonts')

        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.css', 'public/css/bootstrap-table.min.css')
        .copy(paths.icheck + 'icheck.min.js', 'public/js/icheck.min.js')

        .copy(paths.jquery + "dist/jquery.min.js", 'public/js/jquery.min.js')
        .copy(paths.bootstrap + 'javascripts/bootstrap.min.js', 'public/js/bootstrap.min.js')
        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.js', 'public/js/bootstrap-table.min.js')
        .copy(paths.icheck + 'skins/flat', 'public/css/icheck')
        .scripts('app.js', 'public/js/app.min.js');
});

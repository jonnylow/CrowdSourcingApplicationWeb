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
    'fontawesome': './vendor/fortawesome/font-awesome/',
    'bootstraptable': './vendor/wenzhixin/bootstrap-table/',
    'select2': './vendor/select2/'
}

elixir(function(mix) {
    mix.less('app.less')
        .copy(paths.bootstrap + 'dist/fonts', 'public/fonts')
        .copy(paths.fontawesome + 'fonts', 'public/fonts')

        .copy(paths.fontawesome + 'css/font-awesome.min.css', 'public/css/font-awesome.min.css')
        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.css', 'public/css/bootstrap-table.min.css')
        .copy(paths.select2 + 'select2/dist/css/select2.min.css', 'public/css/select2.min.css')
        .copy(paths.select2 + 'select2-bootstrap-theme/dist/select2-bootstrap.min.css', 'public/css/select2-bootstrap.min.css')

        .copy(paths.jquery + "dist/jquery.min.js", 'public/js/jquery.min.js')
        .copy(paths.bootstrap + 'dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.js', 'public/js/bootstrap-table.min.js')
        .copy(paths.bootstraptable + 'dist/extensions/editable/bootstrap-table-editable.min.js', 'public/js/bootstrap-table-editable.min.js')
        .copy(paths.select2 + 'select2/dist/js/select2.min.js', 'public/js/select2.min.js')

        .copy('resources/assets/images', 'public/images')

        .scripts('app.js', 'public/js/app.min.js');
});
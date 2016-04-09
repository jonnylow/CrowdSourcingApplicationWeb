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
    'bootstraptable': './vendor/wenzhixin/bootstrap-table/',
    'bootswatch': './vendor/thomaspark/bootswatch/',
    'fontawesome': './vendor/fortawesome/font-awesome/',
    'jquery': './vendor/thomaspark/bootswatch/bower_components/jquery/',
    'jsvalidation': './public/vendor/jsvalidation/',
    'selectize': './vendor/selectize/selectize.js/',
    'chartjs': './vendor/nnnick/chartjs/'
}

elixir(function(mix) {
    mix.less('app.less')
        .copy(paths.bootstrap + 'dist/fonts', 'public/fonts')
        .copy(paths.fontawesome + 'fonts', 'public/fonts')

        .copy(paths.fontawesome + 'css/font-awesome.min.css', 'public/css/font-awesome.min.css')
        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.css', 'public/css/bootstrap-table.min.css')
        .copy(paths.selectize + 'dist/css/selectize.bootstrap3.css', 'public/css/selectize.bootstrap3.css')

        .copy(paths.jquery + "dist/jquery.min.js", 'public/js/jquery.min.js')
        .copy(paths.bootstrap + 'dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
        .copy(paths.jsvalidation + 'js/jsvalidation.min.js', 'public/js/jsvalidation.min.js')
        .copy(paths.bootstraptable + 'dist/bootstrap-table.min.js', 'public/js/bootstrap-table.min.js')
        .copy(paths.bootstraptable + 'dist/extensions/cookie/bootstrap-table-cookie.min.js', 'public/js/bootstrap-table-cookie.min.js')
        .copy(paths.bootstraptable + 'dist/extensions/natural-sorting/bootstrap-table-natural-sorting.min.js', 'public/js/bootstrap-table-natural-sorting.min.js')
        .copy(paths.bootstraptable + 'dist/extensions/filter-control/bootstrap-table-filter-control.min.js', 'public/js/bootstrap-table-filter-control.min.js')
        .copy(paths.selectize + 'dist/js/standalone/selectize.min.js', 'public/js/selectize.min.js')
        .copy(paths.chartjs + 'Chart.min.js', 'public/js/chart.min.js')

        .copy('resources/assets/images', 'public/images')

        .scripts('app.js', 'public/js/app.min.js');
});
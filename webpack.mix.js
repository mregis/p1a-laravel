const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
//    .less('resources/assets/less/app.less', 'public/css/appfill.css')
    .sass('resources/assets/sass/app.scss', 'public/css/appmain.css')
    .js('resources/assets/js/app.js', 'public/js')
    .scripts([
        'node_modules/promise-polyfill/dist/polyfill.min.js',
        ], 'public/js/polyfill.min.js')
    .scripts([
//        'resources/assets/js/bootstrap-multiselectsplitter.js',
//        'node_modules/bootstrap-markdown/js/bootstrap-markdown.js',
        'node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
        'node_modules/handlebars/dist/handlebars.js',
//        'node_modules/sweetalert2/dist/sweetalert2.js',
//        'node_modules/morris.js/morris.js',
//        'resources/assets/js/bootstrap-session-timeout.js',
//        'resources/assets/js/jquery-idletimer.js',
//        'node_modules/waypoints/src/waypoint.js',
//        'node_modules/counterup/jquery.counterup.js',
//        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
//        'node_modules/jquery-maskmoney/src/jquery.maskMoney.js',
//        'resources/assets/js/bootstrapValidator.js',
//        'node_modules/gijgo/js/gijgo.min.js',
//        'node_modules/gijgo/js/messages/messages.pt-br.js',
//        'node_modules/bootstrap-notify/bootstrap-notify.js',
//        'node_modules/jszip/dist/jszip.min.js',
//        'node_modules/pdfmake/build/pdfmake.min.js',
//        'node_modules/typeahead.js/dist/typeahead.bundle.min.js',
        'node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'
    ], 'public/js/noCommonJS.libs.js')
    // Dropzone
    .copy('node_modules/dropzone/dist/dropzone.css', 'public/css/dropzone.css')
    .scripts(['node_modules/dropzone/dist/min/dropzone.min.js'], 'public/js/dropzone.js')
    .scripts(['resources/assets/js/login.js'], 'public/js/login.js')
    .scripts([
        'resources/assets/js/custom.initializers.js',
        'resources/assets/js/metronic.js',
//        'resources/assets/js/dashboard.js',
        'resources/assets/js/custom.functions.js',
//        'resources/assets/js/select2.js',
    ], 'public/js/custom.scripts.js')
    .extract([
        'jquery',
//        'js-cookie', 'wnumb', 'jquery.input',
//        'handlebars',
        'moment',
        'datatables.net-bs4',
        'datatables.net-buttons-bs4',
        'datatables.net-buttons/js/buttons.colVis.js',
        'datatables.net-buttons/js/buttons.html5.js',
        'datatables.net-buttons/js/buttons.print.js',
        'datatables.net-responsive-bs4',
        'pdfmake/build/pdfmake.js',
        'pdfmake/build/vfs_fonts.js',
        'jszip',
//        'datetime-moment',
        'jquery-form',
//        'jquery-easing',
//        'select2', 'inputmask', 'blockui', 'bootstrap-validator',
//        'bootstrap-touchspin',
//        'bootstrap-select', 'autosize', 'clipboard',
//        'ion-rangeslider', 'summernote', 'jquery-validation',
//        'jstree', 'raphael', 'chartist', 'chart.js'
    ])
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'],
    })
    .copy('resources/assets/icons/favicon.ico', 'public/favicon.ico')
    .copyDirectory('resources/assets/img', 'public/images')
    .version()
;
/* *
module.exports = {
    module: {
        loaders: [
            { test: /jquery-mousewheel/, loader: "imports?define=>false&this=>window" },
            { test: /malihu-custom-scrollbar-plugin/, loader: "imports?define=>false&this=>window" }
        ]
    }
};
/* */
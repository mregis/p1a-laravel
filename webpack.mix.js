let mix = require('laravel-mix');

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
    .less('resources/assets/less/app.less', 'public/css/appfill.css')
    .sass('resources/assets/sass/app.scss', 'public/css/appmain.css')
    .js('resources/assets/js/app.js', 'public/js')
    .scripts([
        'node_modules/promise-polyfill/dist/polyfill.min.js',
        ], 'public/js/polyfill.min.js')
    .scripts([
        'resources/assets/js/bootstrap-multiselectsplitter.js',
        'node_modules/bootstrap-markdown/js/bootstrap-markdown.js',
        'node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
        'node_modules/handlebars/dist/handlebars.js',
        'node_modules/sweetalert2/dist/sweetalert2.js',
        'node_modules/morris.js/morris.js',
        'resources/assets/js/bootstrap-session-timeout.js',
        'resources/assets/js/jquery-idletimer.js',
        'node_modules/waypoints/src/waypoint.js',
        'node_modules/counterup/jquery.counterup.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'node_modules/jquery-maskmoney/src/jquery.maskMoney.js',
        'resources/assets/js/bootstrapValidator.js',
        'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        'node_modules/bootstrap-datepicker/js/locales/bootstrap-datepicker.pt-BR.js',
        'node_modules/bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js',
        'node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
        'node_modules/bootstrap-notify/bootstrap-notify.js',
        'node_modules/jszip/dist/jszip.min.js',
        'node_modules/pdfmake/build/pdfmake.min.js',
        'node_modules/typeahead.js/dist/typeahead.bundle.min.js',
    ], 'public/js/noCommonJS.libs.js')
    .scripts([
        'resources/assets/js/custom.initializers.js',
        'resources/assets/js/metronic.js',
        'resources/assets/js/dashboard.js',
        'resources/assets/js/custom.functions.js',
        'resources/assets/js/select2.js',
    ], 'public/js/custom.scripts.js')
    .extract(['jquery', 'bootstrap', 'vue',        
        'js-cookie', 'wnumb', 'jquery.input',
        'datatables.net', 'datatables.net-bs4',
        'datatables.net-responsive', 'datatables.net-buttons',
        'datatables.net-buttons-bs4', 'datatables.net-responsive-bs4',
        'datatables.net-buttons/js/buttons.colVis.js',
        'datatables.net-buttons/js/buttons.html5.js',
        'datatables.net-buttons/js/buttons.print.js',
        'select2', 'inputmask', 'blockui', 'bootstrap-validator',
        'dropzone', 'malihu-custom-scrollbar-plugin',        
        'jquery-form', 'daterangepicker', 'bootstrap-touchspin',
        'bootstrap-select', 'autosize', 'clipboard',
        'ion-rangeslider', 'summernote', 'jquery-validation',
        'jstree', 'raphael', 'chartist', 'chart.js',
    ])
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'],
    })
    .copy('resources/assets/icons/favicon.ico', 'public/favicon.ico')
    .copyDirectory('resources/assets/img', 'public/images')
    .version()
    .webpackConfig({
        node: {
            fs: "empty"
        }
    })
;

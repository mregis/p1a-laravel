
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    global.$ = global.jQuery = require('jquery');
    require('bootstrap');
    require('jquery-form');
/*
    require('js-cookie');
    require('wnumb');
    require('jquery.input');
    require('blockui');
    require('bootstrap-touchspin');
    require('bootstrap-maxlength');
    require('bootstrap-select');
    require('select2')(window, $);
    var Inputmask = require('inputmask');
    require('nouislider');
    require('autosize');
    require('clipboard');
    require('ion-rangeslider');
    require('summernote');
    require('jquery-validation');
    require('jstree');
    require('raphael');
    require('chartist');
    require('chart.js');
    require('jquery-mask-plugin');
    require('bootstrap-validator')(window, $);
*/

//    window.Handlebars = require('handlebars');
//    require('jquery-easing');
//    require("jquery-mousewheel")(window, $);

    window.moment = require('moment');
    // ### Datatables
    window.JSZip = require( 'jszip' );
    require( 'datatables.net-bs4' );
    require( 'datatables.net-buttons-bs4' );
    require( 'datatables.net-buttons/js/buttons.colVis.js' );
    require( 'datatables.net-buttons/js/buttons.flash.js' );
    require( 'datatables.net-buttons/js/buttons.html5.js' );
    require( 'datatables.net-buttons/js/buttons.print.js' );
    require( 'datatables.net-responsive-bs4' );
    // pdfMake for Datatables HTML5 Buttons
    var pdfMake = require('pdfmake/build/pdfmake.js');
    var pdfFonts = require('pdfmake/build/vfs_fonts.js');
    pdfMake.vfs = pdfFonts.pdfMake.vfs;

//    require('datetime-moment');

    // ### Toastr messages
    window.toastr = require('toastr');

/*
    require('tether');
    require('markdown');
*/

    // Fonts
    require('@fortawesome/fontawesome-free');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


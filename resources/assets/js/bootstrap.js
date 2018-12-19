window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    require('@fortawesome/fontawesome-free');

    var $ = require('jquery');
    global.$ = global.jQuery = $;

//    window.jQuery = $;
//    window.$ = $;

    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('js-cookie');
    require('wnumb');
    require('jquery.input');
    require('jquery-form');
    require('malihu-custom-scrollbar-plugin')(window, $);
    require('blockui');
    require('daterangepicker')(window, $);
    require('bootstrap-touchspin');
    require('bootstrap-maxlength');
    require('bootstrap-select');
    require('select2')(window, $);
    require('typeahead.js');
    var Inputmask = require('inputmask');
    require('nouislider');
    require('autosize');
    require('clipboard');
    require('ion-rangeslider');
    require('dropzone')(window, $);
    require('summernote');
    require('jquery-validation');
    require('toastr');
    require('jstree');
    require('raphael');
    require('chartist');
    require('chart.js');
    require('fullcalendar');
    require('jquery-mask-plugin');
    require('bootstrap-validator')(window, $);
    require('jquery-easing');

    require('datatables.net')( window, $)
    require('datatables.net-bs4')(window, $);
    require('datatables.net-responsive')(window, $);
    require('datatables.net-responsive-bs4')(window, $);
    require('datatables.net-buttons')(window, $);
    require('datatables.net-buttons-bs4')(window, $);
    require('datatables.net-select')(window, $);
    require('datatables.net-select-bs4')(window, $);
    require('datatables.net-buttons/js/buttons.colVis.js')();
    require('datatables.net-buttons/js/buttons.html5.js')();
    require('datatables.net-buttons/js/buttons.flash.js')();
    require('datatables.net-buttons/js/buttons.print.js')();

    require('tether');
    require('markdown');

    // ### For Datatables pdf export
    // require('pdfmake');
    // pdfMake.vfs = pdfFonts.pdfMake.vfs;

} catch (e) {
}

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

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

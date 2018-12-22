/**
 * Created by Marcos Regis on 03/12/2018.
 */

// multiselectsplitter.js
+function(a){"use strict";function c(c){return this.each(function(){var d=a(this),e=d.data("multiselectsplitter"),f="object"==typeof c&&c;(e||"destroy"!=c)&&(e||d.data("multiselectsplitter",e=new b(this,f)),"string"==typeof c&&e[c]())})}var b=function(a,b){this.init("multiselectsplitter",a,b)};b.DEFAULTS={selectSize:null,maxSelectSize:null,clearOnFirstChange:!1,onlySameGroup:!1,groupCounter:!1,maximumSelected:null,afterInitialize:null,maximumAlert:function(a){alert("Only "+a+" values can be selected")},createFirstSelect:function(a,b){return"<option>"+a+"</option>"},createSecondSelect:function(a,b){return"<option>"+a+"</option>"},template:'<div class="row" data-multiselectsplitter-wrapper-selector><div class="col-xs-6 col-sm-6"><select class="form-control" data-multiselectsplitter-firstselect-selector></select></div> <!-- Add the extra clearfix for only the required viewport --><div class="col-xs-6 col-sm-6"><select class="form-control" data-multiselectsplitter-secondselect-selector></select></div></div>'},b.prototype.init=function(c,d,e){var f=this;f.type=c,f.last$ElementSelected=[],f.initialized=!1,f.$element=a(d),f.$element.hide(),f.options=a.extend({},b.DEFAULTS,e),f.$element.after(f.options.template),f.$wrapper=f.$element.next("div[data-multiselectsplitter-wrapper-selector]"),f.$firstSelect=a("select[data-multiselectsplitter-firstselect-selector]",f.$wrapper),f.$secondSelect=a("select[data-multiselectsplitter-secondselect-selector]",f.$wrapper);var g=0,h=0;if(0!=f.$element.find("optgroup").length){f.$element.find("optgroup").each(function(){var b=a(this).attr("label"),c=a(f.options.createFirstSelect(b,f.$element));c.val(b),c.attr("data-current-label",c.text()),f.$firstSelect.append(c);var d=a(this).find("option").length;d>h&&(h=d),g++});var i=Math.max(g,h);i=Math.min(i,10),f.options.selectSize?i=f.options.selectSize:f.options.maxSelectSize&&(i=Math.min(i,f.options.maxSelectSize)),f.$firstSelect.attr("size",i),f.$secondSelect.attr("size",i),f.$element.attr("multiple")&&f.$secondSelect.attr("multiple","multiple"),f.$element.is(":disabled")&&f.disable(),f.$firstSelect.on("change",a.proxy(f.updateParentCategory,f)),f.$secondSelect.on("click change",a.proxy(f.updateChildCategory,f)),f.update=function(){if(!(f.$element.find("option").length<1)){var b,a=f.$element.find("option:selected:first");b=a.length?a.parent().attr("label"):f.$element.find("option:first").parent().attr("label"),f.$firstSelect.find('option[value="'+b+'"]').prop("selected",!0),f.$firstSelect.trigger("change")}},f.update(),f.initialized=!0,f.options.afterInitialize&&f.options.afterInitialize(f.$firstSelect,f.$secondSelect)}},b.prototype.disable=function(){this.$secondSelect.prop("disabled",!0),this.$firstSelect.prop("disabled",!0)},b.prototype.enable=function(){this.$secondSelect.prop("disabled",!1),this.$firstSelect.prop("disabled",!1)},b.prototype.createSecondSelect=function(){var b=this;b.$secondSelect.empty(),a.each(b.$element.find('optgroup[label="'+b.$firstSelect.val()+'"] option'),function(c,d){var e=a(this).val(),f=a(this).text(),g=a(b.options.createSecondSelect(f,b.$firstSelect));g.val(e),a.each(b.$element.find("option:selected"),function(b,c){a(c).val()==e&&g.prop("selected",!0)}),b.$secondSelect.append(g)})},b.prototype.updateParentCategory=function(){var a=this;a.last$ElementSelected=a.$element.find("option:selected"),a.options.clearOnFirstChange&&a.initialized&&a.$element.find("option:selected").prop("selected",!1),a.createSecondSelect(),a.checkSelected(),a.updateCounter()},b.prototype.updateCounter=function(){var b=this;b.$element.attr("multiple")&&b.options.groupCounter&&a.each(b.$firstSelect.find("option"),function(c,d){var e=a(d).val(),f=a(d).data("currentLabel"),g=b.$element.find('optgroup[label="'+e+'"] option:selected').length;g>0&&(f+=" ("+g+")"),a(d).html(f)})},b.prototype.checkSelected=function(){var b=this;if(b.$element.attr("multiple")&&b.options.maximumSelected){var c=0;if(c="function"==typeof b.options.maximumSelected?b.options.maximumSelected(b.$firstSelect,b.$secondSelect):b.options.maximumSelected,!(c<1)){var d=b.$element.find("option:selected");if(d.length>c){b.$firstSelect.find("option:selected").prop("selected",!1),b.$secondSelect.find("option:selected").prop("selected",!1),b.initialized?(b.$element.find("option:selected").prop("selected",!1),b.last$ElementSelected.prop("selected",!0)):a.each(b.$element.find("option:selected"),function(b,d){b>c-1&&a(d).prop("selected",!1)});var e=b.last$ElementSelected.first().parent().attr("label");b.$firstSelect.find('option[value="'+e+'"]').prop("selected",!0),b.createSecondSelect(),b.options.maximumAlert(c)}}}},b.prototype.basicUpdateChildCategory=function(b,c){var d=this;d.last$ElementSelected=d.$element.find("option:selected");var e=d.$secondSelect.val();a.isArray(e)||(e=[e]);var f=d.$firstSelect.val(),g=!1;d.$element.attr("multiple")?d.options.onlySameGroup?a.each(d.$element.find("option:selected"),function(b,c){if(a(c).parent().attr("label")!=f)return g=!0,!1}):c||(g=!0):g=!0,g?d.$element.find("option:selected").prop("selected",!1):a.each(d.$element.find("option:selected"),function(b,c){f==a(c).parent().attr("label")&&a.inArray(a(c).val(),e)==-1&&a(c).prop("selected",!1)}),a.each(e,function(a,b){d.$element.find('option[value="'+b+'"]').prop("selected",!0)}),d.checkSelected(),d.updateCounter(),d.$element.trigger("change")},b.prototype.updateChildCategory=function(b){"change"==b.type?this.timeOut=setTimeout(a.proxy(function(){this.basicUpdateChildCategory(b,b.ctrlKey)},this),10):"click"==b.type&&(clearTimeout(this.timeOut),this.basicUpdateChildCategory(b,b.ctrlKey))},b.prototype.destroy=function(){this.$wrapper.remove(),this.$element.removeData(this.type),this.$element.show()},a.fn.multiselectsplitter=c,a.fn.multiselectsplitter.Constructor=b,a.fn.multiselectsplitter.VERSION="1.0.1"}(jQuery);

jQuery.validator.setDefaults({
    errorElement: 'div', //default input error message container
    errorClass: 'form-control-feedback', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "",  // validate all fields including form hidden input

    errorPlacement: function(error, element) { // render error placement for each input type
        var group = $(element).closest('.m-form__group-sub').length > 0 ? $(element).closest('.m-form__group-sub') : $(element).closest('.m-form__group');
        var help = group.find('.m-form__help');

        if (group.find('.form-control-feedback').length !== 0) {
            return;
        }

        if (help.length > 0) {
            help.before(error);
        } else {
            if ($(element).closest('.input-group').length > 0) {
                $(element).closest('.input-group').after(error);
            } else {
                if ($(element).is(':checkbox')) {
                    $(element).closest('.m-checkbox').find('>span').after(error);
                } else {
                    $(element).after(error);
                }
            }
        }
    },

    highlight: function(element) { // hightlight error inputs
        var group = $(element).closest('.m-form__group-sub').length > 0  ? $(element).closest('.m-form__group-sub') : $(element).closest('.m-form__group');

        console.log('add' + group.attr('class'));

        group.addClass('has-danger'); // set error class to the control groupx
    },

    unhighlight: function(element) { // revert the change done by hightlight
        var group = $(element).closest('.m-form__group-sub').length > 0  ? $(element).closest('.m-form__group-sub') : $(element).closest('.m-form__group');

        group.removeClass('has-danger'); // set error class to the control group
    },

    success: function(label, element) {
        var group = $(label).closest('.m-form__group-sub').length > 0  ? $(label).closest('.m-form__group-sub') : $(label).closest('.m-form__group');

        //group.addClass('has-success').removeClass('has-danger'); // set success class and hide error class
        group.removeClass('has-danger'); // hide error class
        group.find('.form-control-feedback').remove();
    }
});

jQuery.validator.addMethod("email", function(value, element) {
    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
}, "Digite um email válido");
jQuery.notifyDefaults({
    template: '' +
    '<div data-notify="container" class="alert alert-{0} m-alert" role="alert">' +
    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss"></button>' +
    '<span data-notify="icon"></span>' +
    '<span data-notify="title">{1}</span>' +
    '<span data-notify="message">{2}</span>' +
    '<div class="progress" data-notify="progressbar">' +
    '<div class="progress-bar progress-bar-animated bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
    '</div>' +
    '<a href="{3}" target="{4}" data-notify="url"></a>' +
    '</div>'
});

// Sem idéia ao que se refere o código abaixo - Presente no arquivo Vendors do Metronic Theme
(function(t){function z(){for(var a=0;a<g.length;a++)g[a][0](g[a][1]);g=[];m=!1}function n(a,b){g.push([a,b]);m||(m=!0,A(z,0))}function B(a,b){function c(a){p(b,a)}function h(a){k(b,a)}try{a(c,h)}catch(d){h(d)}}function u(a){var b=a.owner,c=b.state_,b=b.data_,h=a[c];a=a.then;if("function"===typeof h){c=l;try{b=h(b)}catch(d){k(a,d)}}v(a,b)||(c===l&&p(a,b),c===q&&k(a,b))}function v(a,b){var c;try{if(a===b)throw new TypeError("A promises callback cannot return that same promise.");if(b&&("function"===
    typeof b||"object"===typeof b)){var h=b.then;if("function"===typeof h)return h.call(b,function(d){c||(c=!0,b!==d?p(a,d):w(a,d))},function(b){c||(c=!0,k(a,b))}),!0}}catch(d){return c||k(a,d),!0}return!1}function p(a,b){a!==b&&v(a,b)||w(a,b)}function w(a,b){a.state_===r&&(a.state_=x,a.data_=b,n(C,a))}function k(a,b){a.state_===r&&(a.state_=x,a.data_=b,n(D,a))}function y(a){var b=a.then_;a.then_=void 0;for(a=0;a<b.length;a++)u(b[a])}function C(a){a.state_=l;y(a)}function D(a){a.state_=q;y(a)}function e(a){if("function"!==
    typeof a)throw new TypeError("Promise constructor takes a function argument");if(!1===this instanceof e)throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");this.then_=[];B(a,this)}var f=t.Promise,s=f&&"resolve"in f&&"reject"in f&&"all"in f&&"race"in f&&function(){var a;new f(function(b){a=b});return"function"===typeof a}();"undefined"!==typeof exports&&exports?(exports.Promise=s?f:e,exports.Polyfill=e):"function"==
typeof define&&define.amd?define(function(){return s?f:e}):s||(t.Promise=e);var r="pending",x="sealed",l="fulfilled",q="rejected",E=function(){},A="undefined"!==typeof setImmediate?setImmediate:setTimeout,g=[],m;e.prototype={constructor:e,state_:r,then_:null,data_:void 0,then:function(a,b){var c={owner:this,then:new this.constructor(E),fulfilled:a,rejected:b};this.state_===l||this.state_===q?n(u,c):this.then_.push(c);return c.then},"catch":function(a){return this.then(null,a)}};e.all=function(a){if("[object Array]"!==
    Object.prototype.toString.call(a))throw new TypeError("You must pass an array to Promise.all().");return new this(function(b,c){function h(a){e++;return function(c){d[a]=c;--e||b(d)}}for(var d=[],e=0,f=0,g;f<a.length;f++)(g=a[f])&&"function"===typeof g.then?g.then(h(f),c):d[f]=g;e||b(d)})};e.race=function(a){if("[object Array]"!==Object.prototype.toString.call(a))throw new TypeError("You must pass an array to Promise.race().");return new this(function(b,c){for(var e=0,d;e<a.length;e++)(d=a[e])&&"function"===
typeof d.then?d.then(b,c):b(d)})};e.resolve=function(a){return a&&"object"===typeof a&&a.constructor===this?a:new this(function(b){b(a)})};e.reject=function(a){return new this(function(b,c){c(a)})}})("undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:this);

swal.mixin({
    width: 400,
    padding: '2.5rem',
    buttonsStyling: false,
    confirmButtonClass: 'btn btn-success m-btn m-btn--custom',
    confirmButtonColor: null,
    cancelButtonClass: 'btn btn-secondary m-btn m-btn--custom',
    cancelButtonColor: null
});

//== Class definition
var Select2 = function() {
    //== Private functions
    var demos = function() {
        // basic
        $('#m_select2_1, #m_select2_1_validate').select2({
            placeholder: "Select a state"
        });

        // nested
        $('#m_select2_2, #m_select2_2_validate').select2({
            placeholder: "Select a state"
        });

        // multi select
        $('#m_select2_3, #m_select2_3_validate').select2({
            placeholder: "Select a state",
        });

        // basic
        $('#m_select2_4').select2({
            placeholder: "Select a state",
            allowClear: true
        });

        // loading data from array
        var data = [{
            id: 0,
            text: 'Enhancement'
        }, {
            id: 1,
            text: 'Bug'
        }, {
            id: 2,
            text: 'Duplicate'
        }, {
            id: 3,
            text: 'Invalid'
        }, {
            id: 4,
            text: 'Wontfix'
        }];

        $('#m_select2_5').select2({
            placeholder: "Select a value",
            data: data
        });

        // loading remote data

        function formatRepo(repo) {
            if (repo.loading) return repo.text;
            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";
            if (repo.description) {
                markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
            }
            markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";
            return markup;
        }

        function formatRepoSelection(repo) {
            return repo.full_name || repo.text;
        }

        $("#m_select2_6").select2({
            placeholder: "Search for git repositories",
            allowClear: true,
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });

        // custom styles

        // tagging support
        $('#m_select2_12_1, #m_select2_12_2, #m_select2_12_3, #m_select2_12_4').select2({
            placeholder: "Select an option",
        });

        // disabled mode
        $('#m_select2_7').select2({
            placeholder: "Select an option"
        });

        // disabled results
        $('#m_select2_8').select2({
            placeholder: "Select an option"
        });

        // limiting the number of selections
        $('#m_select2_9').select2({
            placeholder: "Select an option",
            maximumSelectionLength: 2
        });

        // hiding the search box
        $('#m_select2_10').select2({
            placeholder: "Select an option",
            minimumResultsForSearch: Infinity
        });

        // tagging support
        $('#m_select2_11').select2({
            placeholder: "Add a tag",
            tags: true
        });

        // disabled results
        $('.m-select2-general').select2({
            placeholder: "Select an option"
        });
    }

    var modalDemos = function() {
        $('#m_select2_modal').on('shown.bs.modal', function () {
            // basic
            $('#m_select2_1_modal').select2({
                placeholder: "Select a state"
            });

            // nested
            $('#m_select2_2_modal').select2({
                placeholder: "Select a state"
            });

            // multi select
            $('#m_select2_3_modal').select2({
                placeholder: "Select a state",
            });

            // basic
            $('#m_select2_4_modal').select2({
                placeholder: "Select a state",
                allowClear: true
            });
        });
    }

    //== Public functions
    return {
        init: function() {
            demos();
            modalDemos();
        }
    };
}();

//== Class definition
var BootstrapSelect = function () {
    //== Private functions
    var demos = function () {
        // minimum setup
        $('.m_selectpicker').selectpicker();
    }
    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ajaxComplete(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

var historytable = null;
function getHistory(id, url, u) {
    $("span.capalote-placeholder").text('');

    $("#capaLoteHistoryModal").modal();
    $('#capaLoteHistoryModal').on('hidden.bs.modal', function (e) {
        historytable.clear().draw();
    });
    if (typeof(historytable) == "undefined" || historytable == null) {
        historytable = $('#history').DataTable({
            dom: "<'row'<'col-10'r>>" +
            "<'row'<'col-sm-12'B>><'row'<'col-sm-12't>>",
            buttons: {
                dom: {
                    button: {
                        tag: 'button',
                        className: 'btn btn-sm'
                    }
                },
                buttons: [
                    {extend: "print", text: "<i class='fas fa-print'></i> Imprimir", className: 'btn-primary'},
                    {
                        extend: "excelHtml5",
                        text: "<i class='far fa-file-excel'></i> Salvar Excel",
                        title: "CapaLote_{{ date('Y-m-d') }}",
                        className: 'btn-primary'
                    },
                    {
                        extend: "pdfHtml5",
                        text: "<i class='far fa-file-pdf'></i> Salvar PDF",
                        title: "CapaLote_{{ date('Y-m-d') }}",
                        className: 'btn-primary'
                    },
                ],
            },
            language: lang,
            ordering: false,
            columnDefs: [ { targets: [0,1,2,3,4], visible: false } ]
        });
    }
    $.post(url, {id: id, u: u},
        function (r) {
            $("span.capalote-placeholder").text(r.content);
            for (var i in r.history) {
                var hd = new Date(r.history[i].created_at);
                historytable.row.add([
                    r.content,
                    r.from_agency + ': ' + r.origin.nome,
                    r.to_agency + ': ' + r.destin.nome,
                    (new Date(r.file.movimento)).toLocaleDateString(),
                    (new Date(r.created_at)).toLocaleDateString(),
                    r.history[i].description,
                    hd.toLocaleDateString() + ' ' + hd.toLocaleTimeString(),
                    r.history[i].user.name,
                    r.history[i].user.profile,
                    (r.history[i].local || '-')
                ]).draw();
            }
            // historytable.draw();

        }, 'json').fail(function (r) {
            alert('Ocorreu um erro ao tentar recuperar as informações requisitadas.');
        });
}

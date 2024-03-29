/**
 * Created by Marcos Regis on 03/12/2018.
 */

function submitAjaxForm(form) {
    var formDate = new FormData(form[0]);
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        dataType: 'json',
        data: formDate,
        processData: false,
        contentType: false,
    }).done(function (data) {
        $('.modal').hide();
        var modal = $("#on_done_data");
        if (data.success) {
            if (name == "add_client") {
                addAssistent(data.return, data.message);
            }
            else {
                modal.find('.modal-body').find('p').text(data.message);
                modal.modal('show');
            }

            if (data.basepath) {
                modal.find('.modal-body').find('p').text(data.message);
                modal.modal('show');
                setTimeout(function () {
                    location.href = data.basepath;
                }, 2000);
            }
        } else {
            modal.find('.modal-body').find('p').text(data.message);
            modal.modal('show');

        }
    }).fail(function (data) {
        $('.modal').hide();
        var modal = $("#on_error");
        modal.find('.modal-body').find('p').text(data.responseJSON.message);
        modal.modal('show');
    });
}


//validations functions
function notempty(el) {
    if ($.trim(el.val()).length < 1) {
        updateModalError(el);
        return 1;
    } else {
        return 0;
    }
}

function fieldMinChar(el, minLength) {
    if ($.trim(el.val()).length < minLength) {
        updateModalError(el);
        return 1;
    } else {
        return 0;
    }
}

function validEmail(el) {

    //Regex e-mail
    var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (!regex.test(el.val())) {
        updateModalError(el);
        return 1;
    } else {
        return 0;
    }

}

function validdocument(el) {
    // Verifica CPF
    var document = $("#cpf_cnpj").val();
    if ($("#select_cpf_cnpj").val() == "cpf") {
        return validaCpf(el.val());
    }
    // Verifica CNPJ
    else if ($("#select_cpf_cnpj").val() == "cnpj") {
        return validarCNPJ(el.val());
    }
    updateModalError(el);
    return 1;

}

function cnpjvalid(el) {
    if (!validarCNPJ(el.val())) {
        updateModalError(el);
        return 1;
    } else {
        return 0;
    }
}

function cpfvalid(el) {
    if (!validaCpf(el.val())) {
        updateModalError(el);
        return 1;
    } else {
        return 0;
    }
}

function birthdayValid(el) {
    if (!validaDn(el.val())) {
        updateModalError(el);
        return 1;
    } else {
        return 0;
    }
}

function updateModalError(el) {
    el.addClass('input-error');
    var elementDescriptionError = $("#on_error").find("p#description_error");
    elementDescriptionError.html(elementDescriptionError.html() + el.data('error').replace('{{field}}', el.data('label')) + "<br/>");
}

function validaDn(data) {

    if ($.trim(data).length < 8) return false;

    var dateUnformat = data;
    dateUnformat = dateUnformat.split('/').reverse();
    currentDate = new Date();

    if (parseInt(dateUnformat[0]) > (currentDate.getFullYear() - 14) || parseInt(dateUnformat[0]) < (currentDate.getFullYear() - 115)) return false;

    if (parseInt(dateUnformat[1]) > 12 || parseInt(dateUnformat[1]) < 1) return false;

    return !(parseInt(dateUnformat[2]) > 31 || parseInt(dateUnformat[2]) < 1);


}

function validaCpf(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '')
        return false;
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

function validarCNPJ(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') return false;

    if (cnpj.length != 18)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;
}

function waitData() {
    $('body').stop(true, true).addClass("disabled", 500);
}

function removeClassWait() {
    setTimeout(function () {
        $('body').stop(true, true).removeClass("disabled", 500);
    }, 200);
}

var lang = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i><br/> Carregando...',
    "sProcessing": '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i><br/> Processando...',
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"

    }
};

function titleize(text) {
    var loweredText = text.toLowerCase();
    var words = loweredText.split(" ");
    for (var a = 0; a < words.length; a++) {
        var w = words[a];
        var firstLetter = w[0];
        if (w.length > 2) {
            w = firstLetter.toUpperCase() + w.slice(1);
        } else {
            w = firstLetter + w.slice(1);
        }
        words[a] = w;
    }
    return words.join(" ");
}

function addAssistent(id, msg) {
    id = id.split("/")[2];
    var modal = $("#on_done_data");
    var url = window.location.href;
    url = url.replace('/add', '/edit/' + id);
    modal.find('.modal-header').find('h5').text(msg);
    modal.find('.modal-body').find('p').text("Deseja adicionar um responsável?");
    modal.find('.modal-footer').append('<a href="' + url + '" class="btn btn-success">Sim</a>');
    modal.modal('show');
}

function modalDelete(id) {
    var modal = $("#on_done_data");
    $('.modal-footer #buttonModal').remove();
    modal.find('#remove').remove();
    modal.find('.modal-header').find('h5').text("Apagar");
    modal.find('.modal-body').find('p').text("Deseja realmente excluir ?");
    modal.find('.modal-footer').append('<button id="buttonModal" onclick="deleteData(' + id + ')" ' +
        'class="btn btn-danger">Sim</button>');
    modal.modal('show');

}

function modalCheck(id) {
    var modal = $("#on_done_data");
    $('.modal-footer #buttonModal').remove();
    modal.find('.modal-header').find('h5').text("Check");
    modal.find('.modal-body').find('p').text("Deseja realmente executar esta ação ?");
    modal.find('.modal-footer').append('<button id="buttonModal" onclick="checkItem(' + id + ')" class="btn btn-danger">Sim</button>');
    modal.modal('show');

}

function actionAjax(url, type) {
    $.ajax({
        type: type,
        url: url,
        dataType: "json",
    }).done(function (data) {
        var modal = $("#on_done_data");
        $('.modal-footer #buttonModal').remove();
        if (data.success) {
            modal.find('.modal-header').find('h5').text("Sucesso");
            modal.find('.modal-body').find('p').text(data.message);
            modal.modal('show');
        }
        $('#datatable').DataTable().ajax.reload();
    }).fail(function(f) {
        var errormodal = $("#on_error").modal();
        errormodal.find('.modal-body').find('p').text(f.responseJSON.message || f.responseText);
        errormodal.show();
    });
}

function deleteData(id, url) {
    var _url = 'delete/' + id;
    if (typeof url == "undefined") {
        if ($('#delete_url').val() != null) {
            _url = $('#delete_url').val().replace('/\#.*?\#/ig', id);
        }
    }

    actionAjax(_url, "delete");
}

function checkItem(id) {
    var url = $('#check_url').val() + "/" + id;
    actionAjax(url, "delete");
}

function disable(id_user) {
    var url = $("#disable").val() + "/" + id_user;
    actionAjax(url, "get");
}

function active(id_user) {
    var url = $("#active").val() + "/" + id_user;
    actionAjax(url, "get");
}

function changeSelect(id, value) {
    if (value !== undefined) {
        $("#" + id).val(value).trigger('change');
    }
    else {
        $("#" + id).val('selected').trigger('change');
    }
}

function redirect() {
    var redirect = $("#redirect").val();
    if (redirect) {
        window.location = redirect;
    }
    else {
        clearForm();
    }

}
function clearForm() {
    try {
        document.form.reset();
    } catch (e) {

    }
}
function imageZoom() {
    var modal = $('#on_done_data');
    var src = $('#imageList').attr('src');
    modal.find('#remove').remove();
    modal.find('.modal-header').find('h5').text('Imagem');
    modal.find('.modal-body').find('p').text('');
    modal.find('.modal-body').append('<div id="remove" align="center"><img height="620" width="620" class="img-fluid" src=' + src + '></div>');
    modal.modal();
}

var template = null;
// Late Loaders
jQuery(document).ready(function () {

    $(".ajax-form").on('submit', function (e) {
        e.preventDefault();

        // Validade form
        var modalError = $("#on_error"), erros = 0;
        modalError.find("p#description_error").text("");

        $(this).find('input, select').each(function () {
            $(this).removeClass('input-error');
            if ($(this).is(':visible')) {
                var value = eval($(this).data('validation'));
                erros += typeof value === "number" ? value : 0;
            }
        });

        if (erros > 0) {
            modalError.modal('show');
            return false;
        }

        submitAjaxForm($(this));

    });

    var options = {
        onComplete: function (cep) {
            waitData();

            $.ajax({
                type: "GET",
                url: $("#basepath").val() + "/cep/" + cep
            }).done(function (msg) {
                $('.div-Cep label').text('CEP');
                var state = $('select#state');
                var city = $('input#city');
                if (msg.result) {
                    $('input#address').val(msg.endereco);
                    $('input#district').val(msg.bairro);
                    city.val(msg.cidade);
                    city.attr('readonly', 'readonly');
                    state.val(msg.estado);
                    state.css('pointer-events', 'none');
                    state.css('touch-action', 'none');
                    $('input#number').focus();
                    removeClassWait();

                } else {
                    var modal = $("#on_error");
                    city.removeAttr('readonly');
                    state.removeAttr("style");
                    modal.find('.modal-body').find('p').text(msg.message);
                    modal.find('.modal-header').find('h5').text("Erro");
                    modal.modal('show');
                    removeClassWait();

                }
            });

        }
    };

    $('table.checkdetails th').each(function () {
        var check = Array($(this).find("td").eq(1).html());
    });
    if ($("#details-template").length > 0) {
        template = Handlebars.compile($("#details-template").html());
    }
    var columns = Array();
    if ($('#columns').length > 0) {
        $('#columns').val().split(",").forEach(function (valor, chave) {
            columns.push({data: valor});
        });
    }

    if ($('#datatable').hasClass('hasdetails')) {
        columns.unshift({
            className: 'details-control',
            orderable: false,
            searchable: false,
            data: null,
            defaultContent: '',
        });
    }

    var table = $('#datatable').DataTable({
        processing: true,
        "language": lang,
        serverSide: true,
        ajax: $('#baseurl').val(),
        columns: columns,
    });

    $('#nav-list-tab').on("click", function () {
        $('#datatable').DataTable().ajax.reload();
    });

    $("#nav-add-tab").click(function () {
        $('#redirect').val($("#redirect2").val());
    });
    $("#nav-list-tab").click(function () {
        $("#redirect").val('');
    });

    $(document).on('click', '#close-preview', function () {
        $('.image-preview').popover('hide');
        // Hover befor close the preview
        $('.image-preview').hover(
            function () {
                $('.image-preview').popover('show');
            },
            function () {
                $('.image-preview').popover('hide');
            }
        );
    });

    // Create the close button
    var closebtn = $('<button/>', {
        type: "button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class", "close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger: 'manual',
        html: true,
        title: "<strong>Imagem</strong>" + $(closebtn)[0].outerHTML,
        content: "There's no image",
        placement: 'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function () {
        $('.image-preview').attr("data-content", "").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Selecionar imagem");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function () {
        var img = $('<img/>', {
            id: 'dynamic',
            width: 200,
            height: 140
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Trocar");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });

    $('[data-toggle="tooltip"]').tooltip();

    var autodt = null; // Automatic Datatables
    if (typeof(autodt) == "undefined" || autodt == null) {
        autodt = $('table.auto-dt').DataTable({
            dom: "<'row'<'col-10'r>><'row'<'col-5'l><'col-7 text-right'f>>" +
            "<'row'<'col-sm-12'B>><'row'<'col-sm-12't>><'row'<'col-5'i><'col-7'p>>",
            buttons: {
                dom: {
                    button: {
                        tag: 'button',
                        className: 'btn btn-sm'
                    }
                },
                buttons: [
                    {
                        extend: "print",
                        text: "<i class='fas fa-print'></i> Imprimir",
                        className: 'btn-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: "excelHtml5",
                        text: "<i class='far fa-file-excel'></i> Salvar Excel",
                        className: 'btn-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: "pdfHtml5",
                        text: "<i class='far fa-file-pdf'></i> Salvar PDF",
                        className: 'btn-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ],
            },
            language: lang,
            order: [[1, "asc"]]
        });
    }

    if ($("#details-template").length > 0) {

        $('table.hasdetails tbody').on('click', 'td.details-control', function () {
            var tbl = $(this).parents('table:first').hasClass('auto-dt') ? autodt : table;
            var tr = $(this).closest('tr');
            var row = tbl.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                $.each(row.data(), function (index, value) {
                    if (value == null) {
                        row.data()[index] = "---";
                    }
                });
                row.child(template(row.data())).show();
                tr.addClass('shown');
            }
        });
    }

    $('.datepicker').each(function () {
        $(this).datepicker({format: "dd/mm/yyyy", language: "pt-BR"});
   });
});

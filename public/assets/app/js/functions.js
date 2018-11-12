var masks = {
    cpf: "000.000.000-00",
    cnpj: "00.000.000/0000-00",
    phone: "(##) ####-####",
    zipcode: "00000-000",
    cell_phone: "(99) 9 9999-9999",
};

$("#type_assistent").change(function () {
    if ($(this).val() == "Medicina") {
        $('#doc').attr("placeholder", "CRM");
        $('#label_type_assistent').text("CRM");
        $('#showHide').hide('slow');
        $('#showHide').show('slow');
    }
    else if ($(this).val() == "Engenharia") {
        $('#doc').attr("placeholder", "CREA");
        $('#label_type_assistent').text("CREA");
        $('#showHide').hide('slow');
        $('#showHide').show('slow');

    } else if ($(this).val() == "Outros") {
        $('#doc').attr("placeholder", "Outros");
        $('#label_type_assistent').text("Outros");
        $('#showHide').hide('slow');
        $('#showHide').show('slow');
    }
    else {
        return false;
    }
});

$("#select_cpf_cnpj").change(function hide() {
    // $('.cpf_cnpj').val('');
    $('.pf_pj').show('slow');
    if ($(this).val() === "cpf") {
        $('.cpf_cnpj').mask(masks.cpf);
        $('.cpf_cnpj').attr("placeholder", "CPF");
        $('.cpf_cnpj').data("label", "CPF");
        $('#label_cpf_cnpj').text("CPF");
        $('#label_social_name').text("Nome");
        $('#social_name').attr("placeholder", "Nome");
        $('.pf').show('slow');
        $('.pj').hide('slow');

    } else if ($(this).val() === "cnpj") {
        $('.cpf_cnpj').mask(masks.cnpj);
        $('.cpf_cnpj').attr("placeholder", "CNPJ");
        $('.cpf_cnpj').data("label", "CNPJ");
        $('#label_cpf_cnpj').text("CNPJ");
        $('#label_social_name').text("Razão social");
        $('#social_name').attr("placeholder", "Razão social");
        $('.pj').show('slow');
        $('.pf').hide('slow');

    }
});

function pf_pj(selectObject) {
    var type = selectObject.value;

    if (type === 'cnpj') {
        document.getElementById('pf').style.display = 'none';
        document.getElementById('pj').style.display = '';
        document.getElementById('social_name').style.display = '';
        document.getElementById('name').style.display = '';
        // document.getElementById('name').removeAttribute("data-validation");

    }
    else if (type === 'cpf') {
        document.getElementById('pf').style.display = '';
        document.getElementById('pj').style.display = 'none';
        document.getElementById('social_name').style.display = 'none';
        document.getElementById('name').style.display = '';
        // document.getElementById('name').setAttribute("data-validation", "notempty($(this))");
    }

};

function hide_show(selectObject) {
    var type = selectObject.value;
    console.log("od");
    if (type === 'cnpj') {
        document.getElementById('social_name').style.display = '';
        document.getElementById('fantasy_name').style.display = '';
        document.getElementById('name').style.display = 'none';
        document.getElementById('cpf_cnpj').value = '';
        $("#cpf_cnpj").mask(masks.cnpj);

    }
    else if (type === 'cpf') {
        document.getElementById('social_name').style.display = 'none';
        document.getElementById('fantasy_name').style.display = 'none';
        document.getElementById('name').style.display = '';
        document.getElementById('cpf_cnpj').value = '';
        $("#cpf_cnpj").mask(masks.cpf);


    }
};
$("#nav-add-tab").click(function () {
    $('#redirect').val($("#redirect2").val());
});
$("#nav-list-tab").click(function () {
    $("#redirect").val('');
});
$(document).ready(function () {
    $("#cpf").mask(masks.cpf, {reverse: true});
    $("#cep").mask(masks.zipcode, {reverse: true});
    $("#tel").mask(masks.phone);
    $("#doc_cnpj").mask(masks.cnpj, {reverse: true});
    $("#cell_phone").mask(masks.cell_phone);
    $("#type_account").val($("#value_type_account").val());
    var value_type_assistent = $("#value_type_assistent").val();
    changeSelect('type_assistent', value_type_assistent);
    // $("#type_assistent").val(value_type_assistent).trigger('change');
    // setImage($("#id_setImage").val(), $("#src_setImage"));
    try {
        var doc = $("#input_cpf_cnpj").val();
        checkCpfCnpj(doc);
    } catch (e) {

    }

});

function changeSelect(id, value) {
    if (value !== undefined) {
        $("#" + id).val(value).trigger('change');
    }
    else {
        $("#" + id).val('selected').trigger('change');
    }
}

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

$(function () {
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
});

function dateToday() {
    var date = new Date();
    var month = date.getMonth();
    month = month.toString();
    if (month.length == 1) {
        month = parseInt(month);
        month = 1 + month;
        month = "0" + month;
    }
    today = date.getDate() + "-" + month + "-" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes() + "0";
    return today
}

$(function () {
    $("#value").maskMoney();
    $('#form_user').validator();
});
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
$(document).ready(function () {
    $('.js-select_2').select2();
});
$("#end_date").datetimepicker({
    locale: 'pt-BR',
    format: 'dd-mm-yyyy hh:ii',
    autoclose: true,
    todayBtn: true,
    startDate: dateToday()
});

$("#date").datetimepicker({
    format: 'dd-mm-yyyy hh:ii',
    autoclose: true,
    todayBtn: true,
    startDate: dateToday()
})
;$("#date_of_birth").datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    endDate: dateToday()
});

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
        $('#calendar').fullCalendar('refetchEvents');
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
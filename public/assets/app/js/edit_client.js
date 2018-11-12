$(document).ready(function () {
    var doc = $('#input_cpf_cnpj').val();
    doc = (doc.length);
    var state = $('#state_input').val();
    $("#state_edit").val(state).change();

    if (doc >= 18) {
        $('#select_cpf_cnpj').val("cnpj");
        $('.cpf_cnpj').mask(masks.cnpj);
        $('.cpf_cnpj').attr("placeholder", "CNPJ");
        $('.cpf_cnpj').data("label", "CNPJ");
        $('#label_cpf_cnpj').text("CNPJ");
        $('#label_social_name').text("Razão social");
        $('#social_name').attr("placeholder", "Razão social");
        $('.pj').show('slow');
        $('.pf').hide('slow');
    }
    else if (doc <= 14) {
        $('#select_cpf_cnpj').val("cpf");
        $('.cpf_cnpj').mask(masks.cpf);
        $('.cpf_cnpj').attr("placeholder", "CPF");
        $('.cpf_cnpj').data("label", "CPF");
        $('#label_cpf_cnpj').text("CPF");
        $('#label_social_name').text("Nome");
        $('#social_name').attr("placeholder", "Nome");
        $('.pf').show('slow');
        $('.pj').hide('slow');
    }
    $('#parent_id').val($('#parent_id_input').val()).trigger('change');
    console.log(window.location.origin + '/api/contact');
});

function button_a(attr) {
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var title = titleize(attr);
    var action = window.location.origin + '/api/contacts';
    $(wrapper).append(
        '<div class="remove">' +
        '<form method="POST" action="http://127.0.0.1:8000/api/contacts" accept-charset="UTF-8" class="m-form m-form--fit m-form--label-align-right ajax-form">' +
        '<div class="form-group m-form__group row">' +
        '<div class="col-md-12">' +
        '<h6>Adicionar Responsável (' + title + ')</h6>' +
        '</div>' +
        '<div class="col-md-4">' +
        '<label for="contact_name">Nome</label>' +
        '<input type="text" class="form-control m-input" name="contact_name[]" id="contact_name" placeholder="Nome">' +
        '</div>' +
        '<div class="col-md-4">' +
        '<label for="contact_email">Email</label>' +
        '<input type="email" class="form-control m-input" name="contact_email[]" id="contact_email" aria-describedby="emailHelp" placeholder="Email">' +
        '</div>' +
        '<div class="col-md-4">' +
        '<label for="tel">Telefone</label>' +
        '<input type="text" class="form-control m-input" name="contact_phone[]" id="tel" placeholder="Telefone" maxlength="14" autocomplete="off">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-12 text-center">' +
        '<input class="btn btn-success m-btn btn-sm m-btn m-btn--icon m-btn--pill" type="submit" value="Enviar">' +
        '<a href="#" class="btn btn-danger m-btn btn-sm m-btn m-btn--icon m-btn--pill remove_field">' +
        '<span>' +
        '<span>Remover</span>' +
        '</span>' +
        '</a>' +
        '</div>' +
        '</form>' +
        '</div>').hide().show('slow');

    // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="btn btn-danger m-btn btn-sm m-btn m-btn--icon m-btn--pill remove_field">Remove</a></div>'); //add input box

    $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        $(this).closest('.remove').remove();
    })
}

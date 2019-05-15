var masks = {
    cpf: "000.000.000-00",
    cnpj: "00.000.000/0000-00",
    phone: "(##) ####-####",
    zipcode: "00000-000",
    cell_phone: "(99) 99999-9999",
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

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
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

function imageZoom() {
    var modal = $('#on_done_data');
    var src = $('#imageList').attr('src');
    modal.find('#remove').remove();
    modal.find('.modal-header').find('h5').text('Imagem');
    modal.find('.modal-body').find('p').text('');
    modal.find('.modal-body').append('<div id="remove" align="center"><img height="620" width="620" class="img-fluid" src=' + src + '></div>');
    modal.modal();
}
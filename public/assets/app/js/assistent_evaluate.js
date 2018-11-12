const api = {
    assistent: "/api/assistent/",
    assistent_rating: "/api/rating_assistent/show_assistents/",
    rating_form: "/api/rating_assistent/",
};

$(document).ready(function () {
    const url = window.location.origin;
    $.ajax({
        type: "get",
        url: url + api.assistent,
        data: {id_element: $("#assistent_id").val()},
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        success: function (obj) {
            if (obj != null) {
                const data = obj.data;
                const selectbox = $('#assistent_id');
                $.each(data, function (i, d) {
                    $('<option>').val(d.id).text(d.name).appendTo(selectbox);
                });
                var test = assistents_ratign();
                console.log("oi " + test.data);
            }
        }
    });
});

function starclick(id, value) {
    $("#note" + id).val(value);
    var key = ["a", "b", "c", "d", "e"];
    for (i = 0; i <= value; i++) {
        $('#' + key[i - 1] + id).css({'color': 'orange'});
    }
    var j = value;
    do {
        j++;
        $('#' + key[j - 1] + id).css({'color': ''});
    } while (j <= 5) ;
}


$('#cancel').on('click', function () {
    $('#form_evaluete').hide('slow');
});

$('#assistent_id').on('select2:select', function (e) {
    var data = e.params.data;
    var modal = $("#on_done_data");
    const url = window.location.origin;
    $.ajax({
        type: "GET",
        url: url + api.assistent_rating + data.id,
        contentType: "application/json; charset=utf-8",
        data: "{}",
        dataType: "json",
        success: function (data) {
            setInputs(data.data);
            $('#form_evaluete').show('slow');

        },
        error: function (data) {
            modal.find('.modal-body').find('p').text(data.message);
            modal.modal('show');
        }
    });
});

$(".form-evalueate").on('submit', function (e) {
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

    // console.log("erros: " + erros);
    if (erros > 0) {
        modalError.modal('show');
        return false;
    }


    submitAjaxForm($(this));

});

function submitAjaxForm(form) {
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        dataType: 'json',
        data: form.serialize()
    }).done(function (data) {
        var modal = $("#on_done_data");
        if (data.success) {
            modal.find('.modal-body').find('p').text(data.message);
            modal.modal('show');
        } else {
            modal.find('.modal-body').find('p').text(data.message);
            modal.modal('show');
        }
    });
}

function setInputs(data) {
    $('.evaluate_input').val("");
    $('.fa').css({'color': ''});
    var assistent_id = "";
    $.each(data, function (i, d) {
        starclick(i, d.note);
        assistent_id = d.assistent_id;
        if (d.obs) {
            $("#obs").val(d.obs);
        }
    });
    if (assistent_id) {
        $('#evaluate').attr('method', 'PUT');
        $('#evaluate').attr('action', api.rating_form + assistent_id);
        $('#button_sub').val("Alterar");
    }
    else {
        $('#evaluate').attr('method', 'POST');
        $('#evaluate').attr('action', api.rating_form)
        $('#button_sub').val("Avaliar");

    }

}

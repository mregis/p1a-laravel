const api = {
    state: "/api/state/",
    type_expertise: "/api/type_expertise/",
    item_bpo: "/api/items_bpo/",
    bank: "/api/banks/",
    client: "/api/clients",
};

function popula_select(api, id_element, value, option) {
    const url = window.location.origin;
    $.ajax({
        type: "get",
        url: url + api,
        data: {id_element: $("#" + id_element + "").val()},
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        success: function (obj) {
            if (obj != null) {
                const data = obj.data;
                const selectbox = $('#' + id_element);
                selectbox.find('option').remove();
                $('<option selected disabled>').text("Selecione").appendTo(selectbox);
                $.each(data, function (i, d) {
                    $('<option>').val(d[value]).text(d[option]).appendTo(selectbox);
                });
            }
            if ($('#value_state').length) {
                $('#state').val($('#value_state').val());
            }
            if ($('#value_type_expertise').length) {
                $('#type_expertise').val($('#value_type_expertise').val());
            }
            if ($('#value_item_bpo').length) {
                $('#item_bpo').val($('#value_item_bpo').val());
            }
            if ($('#value_accredited_network_id').length) {
                $('#accredited_network_id').val($('#value_accredited_network_id').val());
            }
            if ($('#value_client').length) {
                $('#clients').val($('#value_client').val());
            }

        }
    });
}

$(document).ready(function () {
    popula_select(api.state, "state", "abbr", "name");
    popula_select(api.type_expertise, "type_expertise", "id", "name");
    popula_select(api.item_bpo, "item_bpo", "id", "title");
    popula_select(api.bank, "accredited_network_id", "id", "name");
    popula_select(api.client, "claimed", "id", "social_name");
    popula_select(api.client, "clients", "id", "social_name");
});

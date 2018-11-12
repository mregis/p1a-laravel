jQuery(document).ready(function () {

    //contacts/add | Lista contatos já cadastrados do customer selecionado
    $("select#customer").on('change', function () {

        //Eneble buttons
        $("button#customerListContacts").prop('disabled', false);
        $("button#customerAddContacts").prop('disabled', false);

    });

    $("button#customerAddContacts").on('click', function () {

        $(this).remove();

        $(".wrraper-continue-form").removeClass("hidden");
        $(".m-portlet__foot").removeClass("hidden");

    });

});



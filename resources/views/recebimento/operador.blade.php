@extends('layout')
@section('title', __('Recebimento'))

@section('styles')
    <style type="text/css">
        .bootstrap-tagsinput {
            border: none;
        }

        #loadMe .loader {
            position: relative;
            text-align: center;
            margin: 15px auto 35px auto;
            z-index: 9999;
            display: block;
            width: 80px;
            height: 80px;
            border: 10px solid rgba(0, 0, 0, .3);
            border-radius: 50%;
            border-top-color: #000;
            animation: fa-spin 1.5s ease-in-out infinite;
            -webkit-animation: fa-spin 1.5s ease-in-out infinite;
        }

        /** MODAL STYLING **/

        #loadMe .modal-content {
            border-radius: 0px;
            box-shadow: 0 0 20px 8px rgba(0, 0, 0, 0.7);
        }

        #loadMe .modal-backdrop.show {
            opacity: 0.75;
        }

    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">{{__('Recebimento')}}</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">{{__('Operador')}}</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x"
                                role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1"
                                       role="tab">
                                        <i class="fas fa-barcode"></i> Registrar Capa de Lote</h3>
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2"
                                       role="tab">
                                        <i class="fas fa-tasks"></i> Outras ações
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                <div class="row m-row--no-padding m-row--col-separator-xl">
                                    <div class="col-sm-4">
                                        <div class="form-group m-form__group">
                                            <h4 class="m-portlet__head-text">Lote de Leitura
                                                <i class="far fa-question-circle text-warning" data-toggle="tooltip"
                                                   title="Identifica o grupo de leituras atual.
                                           É possível recuperar leituras anteriores digitando o número do Lote e
                                           em seguida no botão ao lado"></i></h4>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-info" data-toggle="tooltip"
                                                            title="Gera um numero unico para identificar
                                                    o conjunto de leituras"
                                                            onclick="generateLoteNum()">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>

                                                <input class="form-control form-control-lg m-input"
                                                       id="lote" aria-describedby="loteHelp"
                                                       type="text" placeholder="Lote de Leitura"
                                                       value="{{date('YmdHi')}}" data-mask="000000000000">

                                                <div class="input-group-append">
                                                    <button class="btn btn-success" data-toggle="tooltip" id="load-lote"
                                                            title="Recarrega leituras efetuadas anteriormente através do
                                                   Lote indicado"
                                                            onclick="loadLeituras()">
                                                        <i class="fas fa-redo-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group">
                                            <h4 class="m-portlet__head-text">Capa de Lote #</h4>

                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control form-control-lg m-input input-doc"
                                                       id="inputCapaLote" placeholder="Capa de Lote"
                                                       data-mask="0000000000000">

                                                <div class="input-group-append">
                                                    <button class="btn btn-success btn-lg" id="btnAddCapaLote"
                                                            onclick="addCapaLote();">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group">
                                            <h4 class="m-portlet__head-text">Lacre Malote</h4>
                                            <input type="text" name="lacre"
                                                   class="form-control form-control-lg m-input" id="lacre">
                                        </div>

                                        <button class="btn btn-success btn-lg"
                                                data-toggle="modal" data-target="#registrarLeiturasModal"
                                                id="registrar-leituras" disabled="disabled">
                                            <i class="fas fa-pencil-alt"></i> Registrar
                                        </button>
                                        <button class="btn btn-outline-warning btn-lg invisible"
                                                data-toggle="modal" data-target="#limparLeiturasModal"
                                                id="limpar-leituras">
                                            <i class="fas fa-eraser"></i> Limpar
                                        </button>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-7 h3">
                                        <select multiple name="capalote[]" id="selectCapaLote"
                                                class="form-control form-control-lg"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                <table class="table table-responsive table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Lote</th>
                                            <th>Unidade</th>
                                            <th>Registros</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Limpar Leituras -->
    <div class="modal fade" id="limparLeiturasModal" tabindex="-1" role="dialog"
         aria-labelledby="limparLeiturasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-warning">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="limparLeiturasModalLabel">
                        <i class="fas fa-clipboard-list"></i> Limpar Leituras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ao confimar a ação as leituras efetuadas até o momento serão excluídas inclusive
                    da memória do lote informado.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-outline-warning"
                            onclick="limparLeituras()">
                        <i class="far fa-clipboard"></i> Confirmar Exclusão de Leituras
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Leituras -->
    <div class="modal fade" id="registrarLeiturasModal" tabindex="-1" role="dialog"
         aria-labelledby="registrarLeiturasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-warning">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="registrarLeiturasModalLabel">
                        <i class="fas fa-clipboard-check"></i> Registrar as Leituras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ao confimar a ação as Capas de Lotes lidas até o momento serão marcadas como "EM TRANSITO"
                    e não poderão mais serem trabalhadas nesta unidade.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-outline-success"
                            onclick="registrarLeituras()">
                        <i class="far fa-check-square"></i> Confirmar Registro de Leituras
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Loading Content -->
    <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="loadMeLabel">Registrando Capas de Lote Lidas</h5>
                </div>
                <div class="modal-body text-center">
                    <div class="loader"></div>
                    <div>
                        <p>Efetuando o registro das Capas de Lotes.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#selectCapaLote').tagsinput({
                tagClass: function (item) {
                    if (typeof item.state != "undefined") {
                        var c = (item.state == true ? 'badge-info' : 'badge-danger');
                    } else {
                        var c = "badge-secondary";
                    }
                    return "badge " + c + " p-2 mb-2";
                },
                focusClass: "focus",
                allowDuplicates: false,
                itemValue: 'value',
                itemText: 'text',
            });
            $('#selectCapaLote').on('beforeItemAdd', function (event) {
                var tag = event.item.value;
                var lote = $("#lote").val();
                if (!event.options || !event.options.preventPost) {
                    $.post('{{ route('receive.check-capa-lote') }}',
                            {capaLote: tag, lote: lote}, function (response) {
                                // Mark tag with success class
                                $(".tag.badge-secondary")
                                        .addClass("badge-info")
                                        .removeClass("badge-secondary")
                                        .attr({title: "Capa de Lote encontrada", "data-toggle": "tooltip"});
                                $("[data-toogle]").tooltip();
                                $("#limpar-leituras").removeClass('invisible').show();
                                $("#registrar-leituras").attr({disabled: false});
                            }).fail(function (f) {
                                $(".tag.badge-secondary")
                                        .addClass("badge-danger")
                                        .removeClass("badge-secondary")
                                        .attr({title: "Capa de Lote não encontrada", "data-toggle": "tooltip"});

                                // Close all opened modals
                                $('.modal').modal('hide');
                                var errormodal = $("#on_error").modal();
                                errormodal.find('.modal-body').find('p').text(f.responseText);
                                errormodal.show();
                                $("[data-toogle]").tooltip();
                            });
                }
            });

            $('#selectCapaLote').on('beforeItemRemove', function (event) {
                var tag = event.item.value;
                var lote = $("#lote").val();
                if (!event.options || !event.options.preventPost) {
                    $.post('{{ route('recebimento.remove-leitura') }}',
                            {capaLote: tag, lote: lote}, function (response) {
                                $("[data-toogle]").tooltip("hide");
                            }).fail(function (f) {
                                $('#tags-input').tagsinput('add', tag, {preventPost: true});

                                $(".tag.badge-secondary")
                                        .addClass("badge-danger")
                                        .removeClass("badge-secondary")
                                        .attr({title: "Capa de Lote não encontrada", "data-toggle": "tooltip"});
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var errormodal = $("#on_error").modal();
                                errormodal.find('.modal-body').find('p').text(f.responseText);
                                errormodal.show();
                                $("[data-toogle]").tooltip();
                            });
                }
            });

            $('#selectCapaLote').on('itemRemoved', function (event) {
                if ($('#selectCapaLote').tagsinput("items").length < 1) {
                    $("#lote").attr({readonly: false});
                    $("#load-lote").attr({disabled: false});
                    $("#limpar-leituras").hide();
                    $("#registrar-leituras").attr({disabled: true});
                }
            });
        });

        $('#inputCapaLote').keypress(function (e) {
            if (e.which == 13) {
                if ($('#inputCapaLote').val().length == 13) {
                    $('#btnAddCapaLote').click();
                } else {
                    return false;
                }
            }
        });

        function addCapaLote() {
            if ($("#lote").val() == "") {
                // Close all opened modals
                $('.modal').modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p')
                        .text("É obrigatório indicar um Lote de identificação");
                errormodal.show();
                $("#lote").focus();
            } else {
                $("#lote").attr({readonly: true});
                $("#load-lote").attr({disabled: true});
                var capaLote = $('#inputCapaLote').val();
                $('#selectCapaLote').tagsinput('add', {value: capaLote, text: capaLote});
                $('#inputCapaLote').val("").focus();
            }
        }

        function registrarLeituras() {
            var items = $('#selectCapaLote').val();
            var lacre = $('#lacre').val();
            var lote = $("#lote").val();
            if (items.length > 0) {
                $('.modal').modal('hide');
                var loadme = $("#loadMe").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                }).one('shown.bs.modal', function (e) {
                    $.post('{{ route('receive.register-capa-lote') }}',
                            {lacre: lacre, doc: items, lote: lote, _u: '{{ Auth::user()->id }}'},
                            function (r) {
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var successmodal = $("#on_done_data").modal();
                                successmodal.find('.modal-body').find('p').text(r);
                                successmodal.show();
                            }
                    ).done(function () {
                                $('#selectCapaLote').tagsinput('removeAll');
                                $('#lacre').val("");
                                $('#lote').val("").attr({readonly: false});
                                $("#load-lote").attr({disabled: false});
                                $("#limpar-leituras").hide();
                                $("#registrar-leituras").attr({disabled: true});
                            }
                    ).fail(function (f) {
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var errormodal = $("#on_error").modal();
                                errormodal.find('.modal-body').find('p')
                                        .text(f.responseJSON.message || f.responseText || f.message);
                                errormodal.show();
                            });
                });

            } else {
                $('.modal').modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p').text("Não há capa de Lote a ser registrada.");
                errormodal.show();
            }
        }

        function limparLeituras() {
            var items = $('#selectCapaLote').val();
            $(items).each(function (i, tag) {
                $('#selectCapaLote').tagsinput('remove', tag);
            });
            $('.modal').modal('hide');
            var successmodal = $("#on_done_data").modal();
            successmodal.find('.modal-body').find('p').text("Leituras excluídas");
            successmodal.show();
        }

        function loadLeituras() {
            var lote = $("#lote").val();
            $.post('{{ route('recebimento.carregar-leituras') }}',
                    {lote: lote, _u: '{{ Auth::user()->id }}'},
                    function (r) {
                        var items = [];
                        $.each(r.data.leituras, function (leitura, st) {
                            $('#selectCapaLote').tagsinput("add",
                                    {value: leitura, text: leitura, state: st},
                                    {preventPost: true}
                            );
                        });
                        if ($('#selectCapaLote').tagsinput("items").length > 0) {
                            $("#lote").attr({readonly: true});
                            $("#load-lote").attr({disabled: true});
                            $("#limpar-leituras").removeClass("invisible").show();
                            $("#registrar-leituras").attr({disabled: false});
                        }

                        // Close all opened modals
                        $('.modal').modal('hide');
                        var successmodal = $("#on_done_data").modal();
                        successmodal.find('.modal-body').find('p').text(r.message);
                        successmodal.show();
                    }
            ).fail(function (f) {
                        console.log(f);
                        // Close all opened modals
                        $('.modal').modal('hide');
                        var errormodal = $("#on_error").modal();
                        errormodal.find('.modal-body').find('p')
                                .text(f.responseJSON.message || f.responseText || f.message);
                        errormodal.show();
                    });
        }

        function generateLoteNum() {
            if ($("#lote").val() == "") {
                // Somente gerar um novo numero de lote se não estiver iniciado
                $.post("{{route('recebimento.gerar-num-lote')}}", function (r) {
                    $("#lote").val(r.data.lote);
                });
            }
        }
    </script>
@stop

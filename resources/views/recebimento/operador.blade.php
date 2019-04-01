@extends('layout')
@section('title', __('Recebimento'))

@section('styles')
    <style type="text/css">
        .bootstrap-tagsinput {
            border: none;
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
                                id="myTab"
                                role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1"
                                       role="tab">
                                        <i class="fas fa-barcode"></i> Registrar Capa de Lote
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2"
                                       role="tab">
                                        <i class="fas fa-layer-group"></i> Lotes de Leituras
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3"
                                       role="tab">
                                        <i class="fas fa-tasks"></i> Leituras efetuadas
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
                                                            id="renew-num-lote"
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

                                    <div class="col-sm-8 h3 text-right">
                                        <select multiple name="capalote[]" id="selectCapaLote"
                                                class="form-control form-control-lg"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                <div class="table-responsive-sm">
                                    <table class="table table-bordered table-striped auto-dt responsive nowrap"
                                           id="datatable-lotes"
                                           data-server-side="true" data-processing="true"
                                           data-ajax="{{route('recebimento.listar-lotes')}}?_u={{Auth::id()}}"
                                           data-order='[[1, "desc"],[6, "asc"]]'
                                           data-dom='<"row"<"col-sm"l><"col-sm"f>><"row"<"col-sm-12"t>><"row"<"col-3"i><"col-6"p>>'
                                           data-columns='[{"data":"num_lote"},{"data":"created_at"},{"data":"usuario"},{"data":"unidade"},{"data":"lacre"},{"data":"leituras_count"},{"data":"invalidas_count"},{"data":"estado"},{"data":"action"}]'>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Lote</th>
                                            <th>Data Criação</th>
                                            <th>Criado por</th>
                                            <th>Unidade</th>
                                            <th>Lacre</th>
                                            <th>Total</th>
                                            <th>Ausentes</th>
                                            <th>Estado</th>
                                            <th>Ações</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row">
                                    <button class="btn btn-outline-secondary"
                                            onclick="refreshData()">
                                        <i class="fas fa-sync"></i> Atualizar
                                    </button>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped auto-dt responsive nowrap"
                                           id="datatable-leituras"
                                           data-server-side="true" data-processing="true"
                                           data-ajax="{{route('recebimento.listar-leituras')}}?_u={{Auth::id()}}"
                                           data-dom='<"row"<"col-sm"l><"col-sm"f>><"row"<"col-sm-12"t>><"row"<"col-3"i><"col-6"p>>'
                                           data-columns='[{"data":"action", "searchable":false, "orderable":false},{"data":"num_lote"},{"data":"created_at", "searchable":false},{"data":"usuario"},{"data":"capalote"},{"data":"situacao", "searchable":false},{"data":"buttons", "searchable":false, "orderable":false}]'
                                           data-order='[[2, "desc"],[1, "asc"]]'>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th><input type="checkbox" onclick="checkAll(this);"></th>
                                            <th>Lote</th>
                                            <th>Data Leitura</th>
                                            <th>Lido por</th>
                                            <th>Capa de Lote</th>
                                            <th>Situação</th>
                                            <th>Ações</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row">
                                    <button class="btn btn-danger mr-2" data-toggle="modal" id="btnRemoverLeituras"
                                            data-target="#removerLeiturasModal">
                                        <i class="fas fa-times-circle"></i> Remover Leituras
                                    </button>
                                    <button class="btn btn-outline-secondary"
                                            onclick="refreshData()">
                                        <i class="fas fa-sync"></i> Atualizar
                                    </button>
                                </div>
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

    <!-- Modal Remover Leitura[s] -->
    <div class="modal fade" id="removerLeiturasModal" tabindex="-1" role="dialog"
         aria-labelledby="removerLeiturasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-warning">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="removerLeiturasModalLabel">
                        <i class="fas fa-clipboard-list"></i> Remover Leitura<span class="plural hidden">s</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ao confimar a ação a<span class="plural hidden">s</span>
                    leitura<span class="plural hidden">s</span>
                    selecionada<span class="plural">s</span> ser<span class="singular">á</span>
                    <span class="plural hidden">serão</span> excluída<span class="plural">s</span>
                    do lote <span class="lote hidden"></span>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-outline-warning"
                            onclick="removerLeituras()">
                        <i class="far fa-clipboard"></i> Confirmar Exclusão de Leitura<span
                                class="plural hidden">s</span>
                    </button>
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
                            {capaLote: tag, lote: lote, _u: '{{Auth::id()}}'}, function (response) {
                                // Mark tag with success class
                                $(".tag.badge-secondary")
                                        .addClass("badge-info")
                                        .removeClass("badge-secondary")
                                        .attr({title: "Capa de Lote encontrada", "data-toggle": "tooltip"});
                                refreshData();
                            }).fail(function (f) {
                                $(".tag.badge-secondary")
                                        .addClass("badge-danger")
                                        .removeClass("badge-secondary")
                                        .attr({title: "Capa de Lote não encontrada", "data-toggle": "tooltip"});

                                // Close all opened modals
                                $('.modal').modal('hide');
                                var errormodal = $("#on_error").modal();
                                errormodal.find('.modal-body').find('p')
                                        .text(f.message || f.responseJSON.message || f.responseText);
                                errormodal.show();
                                refreshData();
                            });
                }
            });

            $('#selectCapaLote').on('beforeItemRemove', function (event) {
                var tag = event.item.value;
                var lote = $("#lote").val();
                if (!event.options || !event.options.preventPost) {
                    $.post('{{ route('recebimento.remove-leitura') }}',
                            {capaLote: tag, lote: lote, _u: '{{Auth::id()}}'}, function (response) {
                                refreshData();
                            }, 'json')
                            .fail(function (f) {
                                $('#tags-input').tagsinput('add', tag, {preventPost: true});
                                $(".tag.badge-secondary")
                                        .addClass("badge-danger")
                                        .removeClass("badge-secondary")
                                        .attr({title: "Capa de Lote não encontrada", "data-toggle": "tooltip"});
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var errormodal = $("#on_error").modal();
                                errormodal.find('.modal-body').find('p')
                                        .text(f.message || f.responseJSON.message || f.responseText);
                                errormodal.show();
                                $('[data-toogle="tooltip"]').tooltip();
                            });
                }
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
            $('#selectCapaLote').on('change', function (e) {
                if ($(this).val() != "") {
                    $("#limpar-leituras").removeClass('invisible').show();
                    $("#registrar-leituras").attr({disabled: false});
                    $("#lote").attr({readonly: true});
                    $("#load-lote").attr({disabled: true});
                    $("#renew-num-lote").attr({disabled: true});
                } else {
                    $("#lote").attr({readonly: false});
                    $("#load-lote").attr({disabled: false});
                    $("#renew-num-lote").attr({disabled: false});
                    $("#limpar-leituras").hide();
                    $("#registrar-leituras").attr({disabled: true});
                }
            });
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
                                successmodal.find('.modal-body').find('p')
                                        .text(r.message || r.responseJSON.message || r.responseText);
                                successmodal.show();
                            }
                    ).done(function (xhr) {
                                $('#selectCapaLote').tagsinput('removeAll');
                                $('#lacre').val("");
                                $('#lote').val("");
                            }
                    ).fail(function (xhr) {
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var errormodal = $("#on_error").modal();
                                errormodal.find('.modal-body').find('p')
                                        .text(xhr.message || xhr.responseJSON.message || xhr.responseText);
                                errormodal.show();
                            });
                });

            } else {
                $('.modal').modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p')
                        .text("Não há capa de Lote a ser registrada.");
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
                        $.each(r.data.leituras, function (index, leitura) {
                            $('#selectCapaLote').tagsinput("add",
                                    {value: leitura.capalote, text: leitura.capalote, state: leitura.presente},
                                    {preventPost: true}
                            );
                        });

                        // Close all opened modals
                        $('.modal').modal('hide');
                        var successmodal = $("#on_done_data").modal();
                        successmodal.find('.modal-body')
                                .find('p')
                                .text(r.message || r.responseJSON.message || r.responseText);
                        successmodal.show();
                    }
            ).fail(function (f) {
                        // Close all opened modals
                        $('.modal').modal('hide');
                        var errormodal = $("#on_error").modal();
                        errormodal.find('.modal-body').find('p')
                                .text(f.message || f.responseJSON.message || f.responseText);
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

        function filtrarLeituras(lote) {
            $("#datatable-leituras").DataTable().search(lote).draw();
            $('#myTab a[href="#m_tabs_6_3"]').tab('show');
        }

        function carregarLeituras(lote) {
            $("#lote").val(lote);
            $("#load-lote").click();
            $('#myTab a[href="#m_tabs_6_1"]').tab('show');
        }

        function removerLeituras() {
            var leituras = [];
            $('.input-leitura:checked').each(function (ix, obj) {
                leituras.push($(obj).val());
            });
            if (leituras.length > 0) {
                $.post('{{ route('recebimento.remove-leitura') }}',
                        {leituras: leituras, _u: '{{Auth::id()}}'}, function (r) {
                            // Close all opened modals
                            $('.modal').modal('hide');
                            var successmodal = $("#on_done_data").modal();
                            successmodal.find('.modal-body').find('p')
                                    .text(r.message || r.responseJSON.message || r.responseText);
                            successmodal.show();

                            $.each(r.data, function (i, v) {
                                $('#selectCapaLote').tagsinput('remove', v, {preventPost: true})
                            });
                            refreshData();
                        }).fail(function (f) {
                            // Close all opened modals
                            $('.modal').modal('hide');
                            var errormodal = $("#on_error").modal();
                            errormodal.find('.modal-body').find('p')
                                    .text(f.message || f.responseJSON.message || f.responseText);
                            errormodal.show();
                        });
            } else {
                // Close all opened modals
                $('.modal').modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p')
                        .text("Nenhuma leitura foi selecionada para ser excluída!");
                errormodal.show();
                errormodal.on('close.bs.modal', function (e) {
                    errormodal.find('.modal-body').find('p')
                            .text("");
                })
            }
        }

        function checkAll(el) {
            var st = $(el).prop("checked") == true;
            $('.input-leitura').prop('checked', st);
        }

        function removeUmaLeitura(el) {
            $(el).parents('tr').find(':checkbox.input-leitura')
                    .prop('checked', true);
            $('#btnRemoverLeituras').click();
        }

        function refreshData() {
            $('#datatable-leituras').DataTable().ajax.reload();
            $('#datatable-lotes').DataTable().ajax.reload();
            $('[data-toogle="tooltip"]').tooltip("hide");
        }
    </script>
@stop

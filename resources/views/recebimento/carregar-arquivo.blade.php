@extends('layout')
@section('title', __('Carregar Leituras por Arquivo'))

@section('styles')
    <style type="text/css">

        .fa, .fas, .far, .fal, .fab {
            line-height: 1.6;
        }

        .gj-icon {
            line-height: 1 !important;
        }

        .gj-picker-bootstrap [role=header] [role=date] {
            font-size: 18px;
        }

        .gj-picker-bootstrap.datetimepicker [role=header] [role=time] {
            font-size: 16px;
        }

        .datetimepicker td, .datetimepicker th {
            height: 24px;
        }

        .gj-picker-bootstrap table tr td div, .gj-picker-bootstrap table tr th div {
            width: 22px;
            height: 22px;
            line-height: 22px
        }

        .datetimepicker {
            width: auto;
            padding: 0;
        }

        .dropzone {
            padding: 0;
            min-height: 50px;
            width: 100%;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        .dropzone .dz-message {
            margin: 0;
        }
        .bootstrap-tagsinput {
            overflow: auto;
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
        <div class="col">
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
                                        <span class="m-nav__link-text">Recebimento</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Carregar Arquivo</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <h4 class="m-portlet__head-text"><i class="fas fa-file-alt"></i> Carregar Arquivo de Leituras
                        </h4>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group m-form__group form-row">
                                <label for="dt_leitura" class="col-sm-3 col-form-label">Data de Leitura</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-lg m-input" name="dt_leitura"
                                           id="dt_leitura">
                                </div>
                                <i class="far fa-question-circle text-warning"
                                   data-toggle="tooltip" title="Informe a data/hora real da leitura">
                                </i>
                            </div>

                            <div class="form-group m-form__group form-row">
                                <label class="col-sm-3 col-form-label">Lote de Leitura</label>

                                <div class="input-group col-sm-8">
                                            <span class="input-group-prepend">
                                                <button class="btn btn-info" data-toggle="tooltip"
                                                        title="Gera um numero unico para identificar
                                                            o conjunto de leituras"
                                                        onclick="generateLoteNum()">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </span>

                                    <input class="form-control form-control-lg m-input"
                                           id="lote" aria-describedby="loteHelp"
                                           type="text" placeholder="Lote de Leitura"
                                           value="{{date('YmdHi')}}" data-mask="000000000000">
                                </div>
                                <div class="input-group col-sm">
                                    <i class="far fa-question-circle text-warning" data-toggle="tooltip"
                                       title="Identifica o grupo de leituras atual.
                                                   É possível recuperar leituras anteriores digitando o número do Lote e
                                                   em seguida no botão ao lado"></i>
                                </div>
                            </div>

                            <div class="form-group m-form__group form-row">
                                <label for="lacre" class="col-sm-3 col-form-label">Lacre Malote</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-lg m-input" name="lacre"
                                           id="lacre">
                                </div>
                            </div>
                            <div class="form-group m-form__group form-row">
                                <form class="form-horizontal dropzone"
                                      action="{{route('recebimento.ler-arquivo-leituras')}}"
                                      method="POST" id="my-dropzone">
                                    <input type="hidden" name="_u" value="{{Auth::id()}}"/>

                                    <div class="m-dropzone__msg dz-message needsclick m-dropzone m-dropzone--primary">
                                        <h3 class="m-dropzone__msg-title">Carregar Leituras</h3>
                                            <span class="m-dropzone__msg-desc">
                                                Arraste o arquivo ou clique para fazer o upload.
                                                Faça upload de até 5 arquivos</span>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group m-form__group form-row">
                                <button class="btn btn-success btn-lg mr-2"
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
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-form__group form-row">
                                <label>Situação atual da Capa de Lote</label>
                                <span class="badge badge-info p-2 ml-1" title="Leituras com essa cor indicam que a Capa de Lote
                                      ainda não sofreu nenhuma alteração de estado"
                                      data-toggle="tooltip">Normal</span>
                                <span class="badge badge-warning p-2 ml-1"
                                      title="Leituras com essa cor indicam que a Capa de Lote
                                      já sofreu alteração de estado, por exemplo, já ter sido recebidas no destino"
                                      data-toggle="tooltip">Novo estado</span>
                                <span class="badge badge-danger p-2 ml-1"
                                      title="Leituras com essa cor indicam que a Capa de Lote não possue entrada no
                                      sistema e somente será incluída nos registros de Lotes e Leituras"
                                      data-toggle="tooltip">Não encontrada</span>
                            </div>
                            <div class="form-group m-form__group form-row">
                                <div class="h3 text-right">
                                    <select multiple name="leitura[]" id="selectLeitura"
                                            class="form-control form-control-lg"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Loading Content -->
    <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="loadMeLabel">Registrando Leituras</h5>
                </div>
                <div class="modal-body text-center">
                    <div class="loader"></div>
                    <div>
                        <p>Efetuando o registro das Leituras de Capas de Lotes</p>
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
                    Ao confimar a ação, todas as leituras carregadas até o momento serão removidas.
                    Esta ação não pode ser desfeita.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-outline-warning"
                            onclick="limparLeituras()">
                        <i class="far fa-clipboard"></i> Confirmar
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
                    Ao confimar a ação as Capas de Lotes lidas até o momento serão marcadas como
                    "<strong>{{__('status.' . \App\Models\Docs::STATE_IN_TRANSIT)}}</strong>"
                    e não poderão mais serem trabalhadas nesta unidade.
                    As leituras poderão ser consultadas acessando o item de menu
                    <strong>Recebimento > Operador</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="far fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-outline-success"
                            onclick="registrarLeituras()">
                        <i class="far fa-check-square"></i> Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('/js/dropzone.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

        Dropzone.autoDiscover = false;
        var myDropzone = null;
        $(function () {
            myDropzone = new Dropzone("#my-dropzone");
            myDropzone.on("success", function (file, response) {
                // Arquivo carregado e validado
                $.each(response.data, function (i, o) {
                    $('#selectLeitura').tagsinput('add',
                            {value: o.capalote, text: o.capalote, state: o.presente, estado: o.estado},
                            {preventPost: true}
                    );
                });
            });

            $('#dt_leitura').datetimepicker(
                    $.extend(datepickerConfig,{
                        format: 'dd/mm/yyyy HH:MM',
                        value: '',
                        footer: true
                    })
            );

            $('#selectLeitura').tagsinput({
                tagClass: function (item) {
                    if (typeof item.state != "undefined") {
                        var c = (item.state == true ? 'badge-info' : 'badge-danger');
                        if (item.estado == '{{\App\Models\Docs::STATE_RECEIVED}}' ||
                                item.estado == '{{\App\Models\Docs::STATE_THEFT}}'
                        ) {
                            c = 'badge-warning';
                        }
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

            $('#selectLeitura').on('itemRemoved', function (event) {
                if ($('#selectLeitura').tagsinput("items").length < 1) {
                    $("#lote").attr({readonly: false});
                    $("#load-lote").attr({disabled: false});
                    $("#limpar-leituras").hide();
                    $("#registrar-leituras").attr({disabled: true});
                }
            });

            $('#selectLeitura').on('change', function (e) {
                if ($(this).val() != "") {
                    $("#limpar-leituras").removeClass('invisible').show();
                    $("#registrar-leituras").attr({disabled: false});
                } else {
                    $('#lacre').val("");
                    $("#limpar-leituras").hide();
                    $("#registrar-leituras").attr({disabled: true});
                }
            });
        });

        function registrarLeituras() {
            var items = $('#selectLeitura').val();
            var lacre = $('#lacre').val();
            var lote = $("#lote").val();
            var dt_leitura = $("#dt_leitura").val();
            if (items.length > 0) {
                $('.modal').modal('hide');
                var loadme = $("#loadMe").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                }).one('shown.bs.modal', function (e) {
                    $.post('{{ route('recebimento.carregar-arquivo-leituras') }}',
                            {lacre: lacre, leituras: items, lote: lote,
                                _u: '{{ Auth::user()->id }}', dt_leitura: dt_leitura},
                            function (r) {
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var successmodal = $("#on_done_data").modal();
                                successmodal.find('.modal-body').find('p')
                                        .text(r.message || r.responseJSON.message || r.responseText);
                                successmodal.show();
                            }, 'json')
                            .done(function () {
                                limparLeituras();
                                $('#lacre').val("");
                                $('#lote').val("").attr({readonly: false});
                            })
                            .fail(function (f) {
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var errormodal = $("#on_error").modal();
                                errormodal.find('.modal-body').find('p')
                                        .text(f.message || f.responseJSON.message || f.responseText);
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
            $('#selectLeitura').tagsinput('removeAll');
            myDropzone == null  || myDropzone.removeAllFiles();
            $('.modal').modal('hide');
            var successmodal = $("#on_done_data").modal();
            successmodal.find('.modal-body').find('p').text("Leituras excluídas");
            successmodal.show();
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

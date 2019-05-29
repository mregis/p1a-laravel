@extends('layout')
@section('title', __('Carregar Leituras por Arquivo'))

@section('styles')
    <link href="{{ mix('css/dropzone.css')}}" rel="stylesheet" type="text/css">
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
        .dz-success-mark svg g, .dz-success-mark svg g g {
            fill: green;
        }
        .bootstrap-tagsinput {
            overflow: auto;
            border: none;
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

<!--                            <div class="form-group m-form__group form-row">
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
-->
                            <div class="form-group m-form__group form-row">
                                <label for="lacre" class="col-sm-3 col-form-label">Lacre Malote</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-lg m-input" name="lacre"
                                           id="lacre">
                                </div>
                            </div>
                            @if(Auth::user()->profile == \App\Models\Profile::ADMIN)
                            <div class="form-group m-form__group form-row">
                                <label for="unidade" class="col-sm-3 col-form-label">Unidade Leitura</label>

                                <div class="col-sm-8">
                                    <select required="required" class="form-control form-control-lg m-input"
                                            id="unidades" name="unidades">
                                        <option>Selecione uma opção</option>
                                        @foreach($unidades as $u)
                                            <option value="{{$u->id}}">{{$u->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="form-group m-form__group form-row">
                                <form class="form-horizontal dropzone disabled"
                                      action="{{route('recebimento.ler-arquivo-leituras')}}"
                                      method="POST" id="my-dropzone">
                                    <input type="hidden" name="_u" value="{{Auth::id()}}"/>

                                    <div class="m-dropzone__msg dz-message needsclick m-dropzone m-dropzone--primary">
                                        <h3 class="m-dropzone__msg-title">Após preencher a <strong>Data de Leitura</strong>
                                            e o <strong>Lacre de Malote</strong> (se houver),
                                            arraste o arquivo ou clique para fazer o upload.</h3>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group m-form__group form-row">
                                <div id="dropzpone-preview" class="my-dropzpone-preview dropzone-previews"></div>
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
                                <label>Situação do Lote</label>
                                <span class="badge badge-success p-2 ml-1"
                                      title="Lotes com essa cor indicam que as leituras
                                ainda não foram devidamente registradas."
                                      data-toggle="tooltip">Fechado</span>
                                <span class="badge badge-warning p-2 ml-1" title="Lotes com essa cor indicam que as leituras
                                já foram devidamente registradas."
                                      data-toggle="tooltip">Aberto</span>

                                <span class="badge badge-danger p-2 ml-1"
                                      title="Lotes com essa cor indicam que as Capas de Lote já foram lidas
                                      em outro destino"
                                      data-toggle="tooltip">Atrasado</span>
                            </div>
                            <div class="form-group m-form__group form-row">
                                <div class="text-right">
                                    <select multiple name="lote[]" id="selectLote"
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

    <!-- Modal Uploading File -->
    <div class="modal fade" id="my-upload-progress" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="loadMeLabel">Carregando Leituras do Arquivo</h5>
                </div>
                <div class="modal-body text-center">
                    <div class="progress">
                        <div id="my-upload-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar" aria-valuenow="1" aria-valuemin="0" style="width: 1%"
                             aria-valuemax="100">
                        </div>
                    </div>
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
            myDropzone = new Dropzone("#my-dropzone", {timeout:180000});
            myDropzone.on("sending", function (file, xhr, formData) {
                formData.append('dt_leitura', $("#dt_leitura").val());
                formData.append('lacre', $("#lacre").val());
                $("#loadMe").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                });
            });
            myDropzone.on("complete", function (file, response) {
                // Arquivo carregado e validado
                $("#loadMe").modal('hide');
            });
            myDropzone.on("success", function (file, response) {
                // Arquivo carregado e validado
                $.each(response.data, function (i, o) {
                    $('#selectLote').tagsinput('add',
                            {value: o.i, text: o.t, estado: o.s},
                            {preventPost: true}
                    );
                });
                var successmodal = $("#on_done_data").modal();
                successmodal.find('.modal-body').find('p')
                        .text(response.message || response.responseJSON.message || response.responseText);
                successmodal.show();
            });
            myDropzone.on("error", function (file, response) {
                // Arquivo carregado e validado
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p')
                        .text(response.message || response.responseJSON.message || response.responseText);
                errormodal.show();

            });
            $('#dt_leitura').datetimepicker(
                    $.extend(datepickerConfig,{
                        format: 'dd/mm/yyyy HH:MM',
                        value: '',
                        footer: true
                    })
            ).on('change', function(e) {
                        if ($(this).val() == '') {
                            $("#my-dropzone").addClass('disabled');
                        } else {
                            $("#my-dropzone").removeClass('disabled');
                        }
                    });

            $('#selectLote').tagsinput({
                tagClass: function (item) {
                    var c = "badge-secondary";
                    if (typeof item.estado != "undefined") {
                        if (item.estado == '{{\App\Models\Lote::STATE_OPEN}}') {
                            c = 'badge-warning';
                        }
                        if (item.estado == '{{\App\Models\Lote::STATE_CLOSED}}') {
                            c = 'badge-success';
                        }
                    }
                    return "badge " + c + " p-2 mb-2";
                },
                focusClass: "focus",
                allowDuplicates: false,
                itemValue: 'value',
                itemText: 'text',
            });

            $('#selectLote').on('itemRemoved', function (event) {
                if ($('#selectLote').tagsinput("items").length < 1) {
                    $("#lote").attr({readonly: false});
                    $("#load-lote").attr({disabled: false});
                    $("#limpar-leituras").hide();
                    $("#registrar-leituras").attr({disabled: true});
                }
            });

            $('#selectLote').on('change', function (e) {
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
            var items = $('#selectLote').val();
            var lacre = $('#lacre').val();
            var lote = $("#lote").val();
            var u = '{{ Auth::user()->id }}';
            var unidade = null;
            if ($("#unidades").length > 0) { // Tem o elemento para ser selecionado
                unidade = $("#unidades").val();
            }

            var dt_leitura = $("#dt_leitura").val();
            if (items.length > 0) {
                $('.modal').modal('hide');
                var loadme = $("#loadMe").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                }).one('shown.bs.modal', function (e) {
                    $.post('{{ route('recebimento.carregar-arquivo-leituras') }}',
                            {lacre: lacre, lotes: items, _u: u, unidade: unidade},
                            function (r) {
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var successmodal = $("#on_done_data").modal();
                                successmodal.find('.modal-body').find('p')
                                        .text(r.message || r.responseJSON.message || r.responseText);
                                successmodal.show();
                            }, 'json')
                            .done(function (xhr) {
                                limparLeituras(true);
                                $('#lacre').val("");
                                $('#lote').val("").attr({readonly: false});
                            })
                            .fail(function (xhr) {
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

        function limparLeituras(hidemessage) {
            $('#selectLote').tagsinput('removeAll');
            myDropzone == null  || myDropzone.removeAllFiles();
            if (typeof hidemessage == "undefined") {
                $('.modal').modal('hide');
                var successmodal = $("#on_done_data").modal();
                successmodal.find('.modal-body').find('p').text("Leituras excluídas");
                successmodal.show();
            }
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

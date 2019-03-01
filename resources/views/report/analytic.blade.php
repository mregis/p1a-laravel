@extends('layout')
@section('title', __('Relatório Analítico'))

@section('styles')
    <style type="text/css">
        /** SPINNER CREATION **/

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
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{route('home')}}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">Relatórios</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Analítico</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body p-1">
                    <div class="m-portlet m-portlet--tabs m-1">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x"
                                    role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1"
                                           role="tab">
                                            <i class="far fa-list-alt"></i> Relatório Analítico
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2"
                                           role="tab">
                                            <i class="fas fa-tasks"></i> Relatórios disponíveis
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="m-portlet__body p-1">
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">

                                <div class="form-inline m-2">
                                    <div class="form-group">
                                        <label for="di" class="text-right mr-1 ml-2">Período:</label>

                                        <div class="input-group input-daterange">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">De</div>
                                            </div>
                                            <input type="text" class="form-control" readonly="readonly" id="di"
                                                   data-date-end-date="0d" data-date-autoclose="true"
                                                   value="{{date('d/m/Y')}}">

                                            <div class="input-group-prepend input-group-append">
                                                <div class="input-group-text">Até</div>
                                            </div>
                                            <input type="text" class="form-control datepicker" readonly="readonly"
                                                   id="df"
                                                   data-date-end-date="0d" data-date-autoclose="true"
                                                   value="{{date('d/m/Y')}}">
                                        </div>
                                        <span class="text-warning ml-2" title="O período máximo é de 90 dias"
                                              data-toggle="tooltip">
                                            <i class="fas exclamation-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered
                                    responsive nowrap table-hover" id="report-analitico">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Capa de Lote</th>
                                            <th>{{__('tables.movimento')}}</th>
                                            <th>{{__('tables.filetype')}}</th>
                                            <th>Cod Origem</th>
                                            <th>Agencia Origem</th>
                                            <th>Cod Destino</th>
                                            <th>Agencia Destino</th>
                                            <th>{{__('tables.status')}}</th>
                                            <th>{{__('labels.user')}}</th>
                                            <th>{{__('tables.profile')}}</th>
                                            <th>{{__('tables.local')}}</th>
                                            <th>{{__('tables.created_at')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <button class="btn btn-lg btn-info" type="button" onclick="exportResult();"><i
                                            class="far fa-file-excel"></i> Criar Relatório
                                </button>

                            </div>

                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                <div class="container-fluid">
                                    <table class="table table-striped table-hover table-bordered auto-dt nowrap"
                                           data-server-side="false"
                                           data-ajax="{{route('relatorios.analytics-report-list')}}?_u={{Auth::id()}}"
                                           data-columns='[{"data":"filename"},{"data":"params"},{"data":"username"},{"data":"created_at", "orderData":6},{"data":"state"},{"data":"action", "searchable":false,"orderable":false},{"data":"orderdata", "searchable":false,"visible":false}]'
                                           id="datatable-report-list"
                                           data-order='[[6,"desc"]]' data-processing="true"
                                           data-dom='<"row"<"col-sm-6"l><"col-sm-6"f>><"row"<"col-sm"t>><"row"<"col-sm-3"i><"col-sm-6"p>>'
                                            >
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Arquivo</th>
                                            <th>Argumentos</th>
                                            <th>Usuário</th>
                                            <th>Data Criação</th>
                                            <th>Estado atual</th>
                                            <th>Ações</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <button class="btn btn-lg btn-info" type="button"
                                        onclick='$("#datatable-report-list").DataTable().ajax.reload();'>
                                    <i class="fas fa-sync-alt"></i> Atualizar Listagem
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="loadMeLabel">Exportar Relatório Analítico</h5>
                </div>
                <div class="modal-body text-center">
                    <div class="loader"></div>
                    <div>
                        <p>Iniciando a exportação. Por favor aguarde.</p>

                        <p>Este processo pode levar alguns minutos
                            dependendo da quantidade de registros. Tenha paciência.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">

        function deleteReport(id) {
            if (confirm('Tem certeza que deseja excluir o relatório?')) {
                var url = "{{route('relatorios.analytics-report-delete', [0])}}".replace("/0", "/" + id);
                $.post(url, {"_u": "{{Auth::id()}}", "_method": "delete"}, function (response) {
                    var message = response.message ? response.message : 'Nem tudo saiu bem. Tente novamente mais tarde.';
                    $("#description_done").text(message);
                    $("#on_done_data").modal();
                    $("#datatable-report-list").DataTable().ajax.reload();
                }).fail(function (xhr) {
                    var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocorreu um erro. Tente novamente mais tarde.';
                    $("#description_error").text(message);
                    $("#on_error").modal();
                });
            }
        }

        function exportResult() {
            if (report != null) {
                var loadme = $("#loadMe").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                }).one('shown.bs.modal', function (e) {
                    $.post('{{route('relatorios.analytic-export')}}',
                            report.ajax.params(),
                            function (response) {
                                loadme.modal('hide');
                                if (response.data.url != null) {
                                    window.location.href = response.data.url;
                                } else {
                                    var message = response.message ? response.message : 'Ocorreu um erro. Tente novamente mais tarde.';
                                    $("#description_done").text(message);
                                    $("#on_done_data").modal().on('close.bs.modal', function(e) {
                                        $("#datatable-report-list").DataTable().ajax.reload();
                                    });
                                }
                            }, "json").fail(function (xhr) {
                                loadme.modal('hide');
                                var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocorreu um erro. Tente novamente mais tarde.';
                                $("#description_error").text(message);
                                $("#on_error").modal();
                            });
                });

            }
        }
        var report = null; // Automatic Datatables
        $(function () {
            var DataTablesLocalOptions = {
                serverSide: true,
                processing: true,
                responsive: true,
                language: lang,
                ajax: {
                    url: "{{ route('report.analytic') }}",
                    type: "POST",
                    data: function (data) {
                        var _i = jQuery("#di").val();
                        data.di = _i.replace(/\D/g, '-');
                        _i = jQuery("#df").val();
                        data.df = _i.replace(/\D/g, '-');
                        data._u = '{{Auth::id()}}';
                    }
                },
                order: [[1, "desc"], [0, "asc"]],
                columns: [
                    {"data": "content"},
                    {"data": "movimento", "searchable": false},
                    {"data": "constante"},
                    {"data": "from_agency"},
                    {"data": "nome_agencia_origem"},
                    {"data": "to_agency"},
                    {"data": "nome_agencia_destino"},
                    {"data": "status", "searchable": false},
                    {"data": "nome_usuario_criador"},
                    {"data": "perfil_usuario_criador"},
                    {"data": "local"},
                    {"data": "created_at", "searchable": false},
                ]
            };

            if (typeof(report) == "undefined" || report == null) {
                report = $('#report-analitico').DataTable(DataTablesLocalOptions);
                $('#di').change(function () {
                    var a = $('#di').datepicker('getDate').getTime();
                    var b = $('#df').datepicker('getDate').getTime();
                    if (a > b) {
                        $("#df").datepicker('setDate', new Date(a));
                        return;
                    }
                    var maxdiff = 30 * 24 * 60 * 60 * 1000; // 30 dias
                    if (b - a > maxdiff) {
                        $("#df").datepicker('setDate', new Date(a + maxdiff));
                        return;
                    }
                    report.ajax.reload();
                });
                $('#df').change(function () {
                    var a = $('#di').datepicker('getDate').getTime();
                    var b = $('#df').datepicker('getDate').getTime();
                    if (a > b) {
                        $("#di").datepicker('setDate', new Date(b));
                        return;
                    }
                    var maxdiff = 30 * 24 * 60 * 60 * 1000; // 30 dias
                    if (b - a > maxdiff) {
                        $("#di").datepicker('setDate', new Date(b - maxdiff));
                        return;
                    }
                    report.ajax.reload();
                });
            }

            $('.input-daterange input').each(function () {
                $(this).datepicker({format: "dd/mm/yyyy", language: "pt-BR"});
            });
        });
    </script>

@stop
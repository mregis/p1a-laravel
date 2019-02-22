@extends('layout')
@section('title', __('Relatório Analítico'))

@section('content')
    <div class="row"><div class="col-md-12">
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

                <div class="m-portlet__body">
                    <div class="form-inline m-2">
                        <div class="form-group">
                            <label for="di" class="text-right mr-1 ml-2">Período:</label>
                            <div class="input-group input-daterange">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        De
                                    </div>
                                </div>
                                <input type="text" class="form-control" readonly="readonly" id="di"
                                       data-date-end-date="0d" data-date-autoclose="true"
                                       value="{{date('d/m/Y')}}">
                                <div class="input-group-prepend input-group-append">
                                    <div class="input-group-text">
                                        Até
                                    </div>
                                </div>
                                <input type="text" class="form-control" readonly="readonly" id="df"
                                       data-date-end-date="0d" data-date-autoclose="true"
                                       value="{{date('d/m/Y')}}">
                            </div>
                            <span class="text-warning ml-2" title="O período máximo é de 90 dias"
                                    data-toggle="tooltip">
                                <i class="fas exclamation-circle"></i>
                            </span>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered
                    responsive nowrap hasdetails table-hover" id="report-analitico">
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
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script type="text/javascript">
        var report = null; // Automatic Datatables
        $(function () {
            var DataTablesLocalOptions = {
                serverSide: false,
                processing: true,
                responsive: true,
                ordering: false,
                language: lang,
                dom: "<'row'<'col-sm-12'r>><'row'<'col-sm-12 mb-2'B>>" +
                    "<'row'<'col-sm-5'l><'col-sm-7 text-right'f>>" +
                    "<'row'<'col-sm-12't>><'row'<'col-5'i><'col-7'p>>",
                buttons: {
                    dom: {
                        button: {
                            tag: 'button',
                            className: 'btn btn-sm'
                        }
                    },
                    buttons: [
                        {extend: "print", text: "<i class='fas fa-print'></i> Imprimir", className: 'btn-primary'},
                        {
                            extend: "excelHtml5",
                            text: "<i class='far fa-file-excel'></i> Salvar Excel",
                            title: function(){ return "Relatorio_Analitico_" + $("#di").val() + "_" + $("#df").val();},
                            className: 'btn-primary'
                        },
                        {
                            extend: "pdfHtml5",
                            text: "<i class='far fa-file-pdf'></i> Salvar PDF",
                            title: function(){ return "Relatorio_Analitico_" + $("#di").val() + "_" + $("#df").val();},
                            className: 'btn-primary'
                        },
                        {
                            extend: "excel",
                            text: "<i class='fas fa-file-csv'></i> Salvar Excel (CSV)",
                            title: function(){ return "Relatorio_Analitico_" + $("#di").val() + "_" + $("#df").val();},
                            className: 'btn-primary'
                        }
                    ],
                },
                ajax: {
                    url: "{{ route('report.analytic') }}",
                    type: "POST",
                    data: function (data) {
                        var _i = jQuery("#di").val();
                        data.di = _i.replace(/\D/g,'-');
                        _i = jQuery("#df").val();
                        data.df = _i.replace(/\D/g,'-');
                        data._u = '{{Auth::id()}}';
                    }
                },
                order: [[1, "desc"]],
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
                $('#di').change( function() {
                    var a = $('#di').datepicker('getDate').getTime();
                    var b = $('#df').datepicker('getDate').getTime();
                    if (a > b) {
                        $("#df").datepicker('setDate', new Date(a));
                        return;
                    }
                    var maxdiff = 30*24*60*60*1000; // 30 dias
                    if (b - a > maxdiff) {
                        $("#df").datepicker('setDate', new Date(a+maxdiff));
                        return;
                    }
                    report.ajax.reload();
                });
                $('#df').change( function() {
                    var a = $('#di').datepicker('getDate').getTime();
                    var b = $('#df').datepicker('getDate').getTime();
                    if (a > b) {
                        $("#di").datepicker('setDate', new Date(b));
                        return;
                    }
                    var maxdiff = 30*24*60*60*1000; // 30 dias
                    if (b - a > maxdiff) {
                        $("#di").datepicker('setDate', new Date(b-maxdiff));
                        return;
                    }
                    report.ajax.reload();
                });
            }

            $('.input-daterange input').each(function() {
                $(this).datepicker({format: "dd/mm/yyyy", language:"pt-BR"});
            });
        });
    </script>

@stop
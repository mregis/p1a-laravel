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
                                       value="{{date('d/m/Y', strtotime('-90 days'))}}"
                                       >
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
                            <th>{{__('tables.status')}}</th>
                            <th>{{__('tables.movimento')}}</th>
                            <th>{{__('tables.filename')}}</th>
                            <th>{{__('tables.filetype')}}</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>{{__('labels.user')}}</th>
                            <th>{{__('tables.profile')}}</th>
                            <th>{{__('tables.local')}}</th>
                            <th>{{__('labels.seal')}}</th>
                            <th>{{__('tables.created_at')}}</th>
                            <th>{{__('tables.details')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="m-portlet__body">
                    <button class="btn btn-lg btn-info" type="button" onclick="exportResult();"><i class="far fa-file-excel"></i> Exportar</button>
                </div>
            </div>
        </div>
    </div>
    @component('dochistory')
    @endcomponent
@stop

@section('scripts')
    <script type="text/javascript">

        function exportResult() {
            if (report != null) {
                var _data = report.ajax.params();
                var _form = document.createElement("FORM");

                _form.action = '{{route('relatorios.analytic-export')}}';
                _form.method = 'POST';
                _form.target = '_blank';
                var input = document.createElement("input");
                input.type = 'hidden';

                // Period
                var input = document.createElement("input");
                input.type = 'hidden';
                input.name = 'di';
                input.value = _data.di;
                _form.appendChild(input);
                var input = document.createElement("input");
                input.type = 'hidden';
                input.name = 'df';
                input.value = _data.df;
                _form.appendChild(input);

                // Order items
                $.each(_data.order, function(i, item){
                    var input = document.createElement("input");
                    input.type = 'hidden';
                    input.name = 'order[' + i + '][column]';
                    input.value = item.column;
                    _form.appendChild(input);
                    var input = document.createElement("input");
                    input.type = 'hidden';
                    input.name = 'order[' + i + '][dir]';
                    input.value = item.dir;
                    _form.appendChild(input);
                });
                // Search term
                var input = document.createElement("input");
                input.type = 'hidden';
                input.name = 'search[value]';
                input.value = _data.search.value;
                _form.appendChild(input);
                document.body.appendChild(_form);
                _form.submit();
                document.body.removeChild(_form);
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
                        data.di = _i.replace(/\D/g,'-');
                        _i = jQuery("#df").val();
                        data.df = _i.replace(/\D/g,'-');
                        data._u = '{{Auth::id()}}';
                    }
                },
                order: [[2, "desc"]],
                columns: [
                    {"data": "content"},
                    {"data": "status", "searchable": false},
                    {"data": "movimento", "searchable": false},
                    {"data": "filename"},
                    {"data": "constante"},
                    {"data": "from_agency"},
                    {"data": "to_agency"},
                    {"data": "username", "searchable": false, "orderable": false},
                    {"data": "profile", "searchable": false, "orderable": false},
                    {"data": "local", "searchable": false, "orderable": false},
                    {"data": "seals", "searchable": false, "orderable": false},
                    {"data": "created_at", "searchable": false,},
                    {"data": "view", "searchable": false, "orderable": false}
                ]
            };

            if (typeof(report) == "undefined" || report == null) {
                report = $('#report-analitico').DataTable(DataTablesLocalOptions);
                $('#di').change( function() {
                    var a = $('#di').datepicker('getDate').getTime();
                    var b = $('#df').datepicker('getDate').getTime();
                    var maxdiff = 90*24*60*60*1000; // 90 dias
                    if (b - a > maxdiff) {
                        $("#df").datepicker('setDate', new Date(a+maxdiff));
                        return;
                    }
                    report.ajax.reload();
                });
                $('#df').change( function() {
                    var a = $('#di').datepicker('getDate').getTime();
                    var b = $('#df').datepicker('getDate').getTime();
                    var maxdiff = 90*24*60*60*1000; // 90 dias
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
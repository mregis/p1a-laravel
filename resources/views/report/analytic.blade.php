@extends('layout')
@section('title', __('Relatório Analítico'))

@section('content')
    <div class="row"><div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">Analítico</h3>
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
                                <input type="text" class="form-control" readonly="readonly" id="di">
                                <div class="input-group-prepend input-group-append">
                                    <div class="input-group-text">
                                        Até
                                    </div>
                                </div>
                                <input type="text" class="form-control" readonly="readonly" id="df">
                            </div>
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
                            <th>{{__('tables.created_at')}}</th>
                            <th>{{__('tables.details')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @component('dochistory')
    @endcomponent
@stop

@section('scripts')
    <script type="text/javascript">

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
                    {"data": "status"},
                    {"data": "movimento"},
                    {"data": "filename"},
                    {"data": "constante"},
                    {"data": "from_agency"},
                    {"data": "to_agency"},
                    {"data": "username"},
                    {"data": "profile"},
                    {"data": "local"},
                    {"data": "created_at"},
                    {"data": "view"}
                ]
            };

            if (typeof(report) == "undefined" || report == null) {
                report = $('#report-analitico').DataTable(DataTablesLocalOptions);
                $('#di, #df').change( function() {
                    report.ajax.reload();
                });
            }

            $('.input-daterange input').each(function() {
                $(this).datepicker({format: "dd/mm/yyyy", language:"pt-BR"});
            });
        });


    </script>

@stop
@extends('layout')

@section('title', 'DashBoard')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                            <div class="col-md-12">
                                <h3 class="m-widget14__title">Relatório Geral</h3>
                                <div class="m-portlet m-portlet--tab">
                                    <div class="m-portlet__body">
                                        <table class="table table-striped stripe compact table-bordered auto-dt"
                                               data-columns='[{"data": "movimento"},{"data": "pendentea"},{"data":"concluidoa"},{"data": "pendenteb"},{"data":"concluidob"},{"data": "pendentec"},{"data":"concluidoc"}]'
                                               data-ajax='{{ route('dashboard.report', Auth::user()->id) }}'
                                               data-server-side="true" data-order='[[0, "desc"]]'
                                               data-processing="true">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th></th>
                                                    <th colspan="2">Envios para outra Agência</th>
                                                    <th colspan="2">Recebimento de outra Agência</th>
                                                    <th colspan="2">Devolucões Matriz</th>
                                                </tr>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Pendente</th>
                                                    <th>Confirmado</th>
                                                    <th>Pendente</th>
                                                    <th>Confirmado</th>
                                                    <th>Pendente</th>
                                                    <th>Confirmado</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

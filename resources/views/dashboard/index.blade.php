@extends('layout')

@section('title', 'DashBoard')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active m-widget14__title" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                                    <h4 class="m-widget14__title">Envio para outra Agência</h4>
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                                    <h4 class="m-widget14__title">Recebimento de outra Agência</h4>
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab">
                                    <h4 class="m-widget14__title">Devoluções Matriz</h4>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                            <div class="col-md-12">
                                <div class="m-portlet m-portlet--tab">
                                    <div class="m-portlet__body">
                                        <table class="table table-striped stripe compact table-bordered auto-dt"
                                               data-columns='[{"data": "movimento"},{"data": "pendente"},{"data":"concluido"}]'
                                               data-ajax='{{ route('dashboard.envios', Auth::user()->id) }}'
                                               data-order='[[1, "desc"], [0, "desc" ]]'>
                                            <thead class="table-dark">
                                                <th>Data</th>
                                                <th>Pendente</th>
                                                <th>Confirmado</th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                            <div class="col-md-12">
                                <div class="m-portlet m-portlet--tab">
                                    <div class="m-portlet__body">
                                        <table class="table table-striped table-bordered auto-dt"
                                               data-columns='[{"data":"movimento"},{"data":"pendente"},{"data":"concluido"}]'
                                               data-ajax='{{ route('dashboard.recebimentos', Auth::user()->id) }}'
                                               data-order='[[1,"desc"],[0,"desc"]]' style="width: 100%">
                                            <thead class="table-dark">
                                                <th>Data</th>
                                                <th>Pendente</th>
                                                <th>Confirmado</th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                            <div class="col-md-12">
                                <div class="m-portlet m-portlet--tab">
                                    <div class="m-portlet__body">
                                        <table class="table table-striped table-bordered auto-dt"
                                               data-columns='[{"data":"movimento"},{"data":"pendente"},{"data":"concluido"}]'
                                               data-ajax='{{ route('dashboard.devolucoes', Auth::user()->id) }}'
                                               data-order='[[1,"desc"],[0,"desc"]]' style="width: 100%">
                                            <thead class="table-dark">
                                                <th>Data</th>
                                                <th>Pendente</th>
                                                <th>Confirmado</th>
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

@section('scripts')
    <script type="text/javascript">
        $(function() {
           $(".auto-dt").DataTable({
               processing: true,
               language: lang,
               serverSide: true,
               searching: false,
               lengthChange: false
           });
        });
    </script>
@stop
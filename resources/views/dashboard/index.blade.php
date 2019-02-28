@extends('layout')

@section('title', 'Painel de Controle - Acompanhamento')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="javascript:void(0)" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">Painel de Controle</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h4 class="m-portlet__head-text">Acompanhamento</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <table class="table table-striped table-responsive compact table-bordered auto-dt text-center nowrap"
                               data-columns='[{"data": "movimento_sort", "visible":false,"searchable":false},{"data": "movimento","orderData":0},{"data": "pendentea"},{"data":"concluidoa"},{"data": "pendenteb"},{"data":"concluidob"},{"data": "pendentec"},{"data":"concluidoc"}]'
                               data-ajax='{{ route('dashboard.report', Auth::user()->id) }}'
                               data-order='[[1, "desc"]]'
                               data-dom='<"row"<"col-sm"l><"col-sm"B>><"row"<"col-sm-12"t>><"row"<"col-3"i><"col-6"p>>'>
                            <thead class="table-dark">
                                <tr class="border">
                                    <th></th>
                                    <th></th>
                                    <th colspan="2" class="border border-white">Envio para outra Agência</th>
                                    <th colspan="2" class="border border-white">Recebimento outra Agência</th>
                                    <th colspan="2" class="border border-white">Devoluções Matriz</th>
                                </tr>
                            <tr>
                                <th></th>
                                <th class="border border-white">Movimento</th>
                                <th class="border border-white">Pendente</th>
                                <th class="border border-white">Confirmado</th>
                                <th class="border border-white">Pendente</th>
                                <th class="border border-white">Confirmado</th>
                                <th class="border border-white">Pendente</th>
                                <th class="border border-white">Confirmado</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@extends('layout')

@section('title', 'Painel de Controle - Acompanhamento')
@section('content')

<div class="row">
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
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
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <h3 class="m-widget14__title">Relatório Geral</h3>
                <table class="table table-striped table-responsive compact table-bordered auto-dt"
                       data-columns='[{"data": "movimento"},{"data": "pendentea"},{"data":"concluidoa"},{"data": "pendenteb"},{"data":"concluidob"},{"data": "pendentec"},{"data":"concluidoc"}]'
                       data-ajax='{{ route('dashboard.report', Auth::user()->id) }}'
                       data-server-side="true" data-order='[[0, "desc"]]'
                       data-processing="true">
                    <thead class="table-dark text-center">
                    <tr>
                        <td></td>
                        <td colspan="2">Envios para outra Agência</td>
                        <td colspan="2">Recebimento outra Agência</td>
                        <td colspan="2">Devolucões Matriz</td>
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
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

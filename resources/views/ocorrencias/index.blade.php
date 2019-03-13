@extends('layout')

@section('title',  __('titles.alerts'))
@section('content')
    <div class="row">
        <div class="col-sm">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{route('home')}}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">Ocorrências</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Listagem</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption col-sm-6">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <i class="far fa-file-alt"></i>
                                Listagem de Ocorrências
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-caption col-sm-6">
                        <a class="btn btn-success btn-md align-self-end" href="{{route('ocorrencias.add')}}">
                            <i class="fas fa-plus-circle"></i> Nova Ocorrência
                        </a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_6_2" role="tabpanel">
                            <input type="hidden" id="delete_url" value="{{route('ocorrencia.api_delete_ocorrencia', '#ID#')}}" />
                            <table class="table table-hover table-striped auto-dt table-responsive
                                compact nowrap text-center hasdetails"
                                   data-columns='[{"className": "details-control","orderable": false, "data":null,"defaultContent": ""},{"data": "created_at"}, {"data": "user.name"}, {"data": "user.profile"}, {"data": "user.local"}, {"data": "content"}, {"data": "updated_at"}, {"data": "action"}]'
                                   data-server-side="true" data-ajax="{{ route('ocorrencia.list')}}"
                                   data-order='[[1, "desc"]]'>
                                <thead class="table-dark">
                                <tr>
                                    <th></th>
                                    <th>{{__('tables.created_at')}}</th>
                                    <th>{{__('labels.user')}}</th>
                                    <th>{{__('labels.profile')}}</th>
                                    <th>{{__('tables.local')}}</th>
                                    <th>{{__('labels.description')}}</th>
                                    <th>{{__('tables.updated_at')}}</th>
                                    <th>{{__('tables.action')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="checkdetails">
                                <tr>
                                    <th>{{__('titles.historic')}}:</th>
                                    <td>@{{{description}}}</td>
                                </tr>
                            </table>
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

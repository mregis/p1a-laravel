@extends('layout')
@section('title', __('Auditoria'))

@section('content')

    <div class="row">
        <div class="col-12">
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
                                        <h3 class="m-portlet__head-text">Auditoria</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                        <table class="table table-striped auto-dt table-responsive compact nowrap"
                               data-buttons='{"dom":{"button":{"tag": "button","className":"btn btn-sm"}},"buttons":[{"extend": "print", "text": "<i class=\"fas fa-print\"></i> Imprimir", "className": "btn-primary"}]}'
                               data-columns='[{"data": "description"}, {"data": "name"}, {"data": "email"}, {"data": "profile"}, {"data": "created_at"}]'
                               data-server-side="true" data-ajax="{{URL::to('/api/audit/list')}}"
                               data-order='[[4, "desc"]]'
                                >
                            <thead class="thead-dark">
                            <tr>
                                <th>{{__('tables.description')}}</th>
                                <th>{{__('tables.name')}}</th>
                                <th>{{__('tables.email')}}</th>
                                <th>{{__('labels.profile')}}</th>
                                <th>{{__('labels.date')}}</th>
                            </tr>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>

@stop

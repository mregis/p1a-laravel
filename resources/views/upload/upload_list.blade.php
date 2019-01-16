@extends('layout')
@section('title', __('Arquivos'))

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">Remessa (Envio)</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h4 class="m-portlet__head-text">Listagem</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="columns" value="id,name,total,action">
                <input type="hidden" id="baseurl" value="{{URL::to('/api/upload/list')}}">
                <input type="hidden" id="delete_url" value="{{URL::to('/arquivo/delete')}}">

                <div class="m-portlet__body">
                    <table class="table table-striped table-responsive table-hover hasdetails compact text-center"
                           id="datatable" data-column-defs='[{"targets":[0,4],"orderable":false}]'>
                        <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>{{__('tables.id')}}</th>
                            <th>{{__('tables.name')}}</th>
                            <th>{{__('total')}}</th>
                            <th>{{__('tables.options')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <script id="details-template" type="text/x-handlebars-template">
                        <table class="checkdetails">
                            <tr>
                                <td>{{__('labels.name')}}:</td>
                                <td>@{{name}}</td>
                                <td>{{__('Total')}}:</td>
                                <td>@{{total}}</td>
                            </tr>
                            <tr>
                                <td>{{__('tables.created_at')}}:</td>
                                <td>@{{created_at}}</td>
                                <td>{{__('tables.updated_at')}}:</td>
                                <td>@{{updated_at}}</td>
                            </tr>
                        </table>
                    </script>
                </div>
            </div>
        </div>
    </div>

@stop

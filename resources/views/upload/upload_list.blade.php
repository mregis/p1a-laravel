@extends('layout')
@section('title', 'Arquivos')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
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
                <input type="hidden" id="columns" value="name,movimento,created_at,updated_at,total,action">
                <input type="hidden" id="baseurl" value="{{route('upload.list')}}">
                <input type="hidden" id="delete_url" value="{{route('upload.delete', '#file_id#')}}">

                <div class="m-portlet__body">
                    <table class="table table-striped table-responsive table-hover compact nowrap text-center"
                           data-order='[[1,"desc"]]'
                           id="datatable" data-column-defs='[{"targets":[5],"orderable":false}]'>
                        <thead class="thead-dark">
                            <tr>
                                <th>{{__('tables.name')}}</th>
                                <th>{{__('tables.movimento')}}</th>
                                <th>{{__('tables.created_at')}}</th>
                                <th>{{__('tables.updated_at')}}</th>
                                <th>{{__('total')}}</th>
                                <th>{{__('tables.options')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

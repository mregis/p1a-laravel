@extends('layout')
@section('title', __('Arquivos'))

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
                                        <h4 class="m-portlet__head-text">Listagem - Detalhes Arquivo</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Detalhes do arquivo <span class="badge badge-pill badge-primary">{{$file->name}}</span>
                        </h3>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <input type="hidden" id="columns" value="content,created_at,updated_at,status">
                    <input type="hidden" id="baseurl" value="{{ route('report.file_content', [$id, Auth::id()]) }}" />
                    <table class="table table-striped table-hover table-responsive compact nowrap text-center"
                           id="datatable" data-column-defs='[{ "targets":[0], "orderable": false}]'>
                        <thead class="thead-dark">
                        <tr>
                            <th>{{__('Capa Lote')}}</th>
                            <th>{{__('tables.created_at')}}</th>
                            <th>{{__('tables.updated_at')}}</th>
                            <th>{{__('labels.status')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

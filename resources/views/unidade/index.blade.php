@extends('layout')

@section('title',  __('titles.unidades'))
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
                                        <span class="m-nav__link-text">Cadastros</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Unidades</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="m-portlet__body">
                <div class="tab-content">
                    <input type="hidden" id="columns" value="nome,descricao,created_at,action" />
                    <input type="hidden" id="baseurl" value="{{ route('unidades.api-listar') }}" />
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('unidade.novo') }}" class="btn btn-md btn-success"><i class="fas fa-plus-circle"></i> {{ __('labels.add') }}</a>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered table-hover table-striped compact nowrap"
                               id="datatable" data-column-defs='[{"targets":[3],"orderable":false}]'>
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('tables.name') }}</th>
                                <th scope="col">{{ __('tables.description') }}</th>
                                <th scope="col">{{ __('tables.created_at') }}</th>
                                <th scope="col">{{ __('tables.options') }}</th>
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

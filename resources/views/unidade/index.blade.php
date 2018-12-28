@extends('layout')

@section('title',  __('titles.unidades'))
@section('content')
    <div class="row">
    <div class="col-8">
    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="/dashboard" class="m-nav__link m-nav__link--icon">
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
                <span class="m-nav__link-text">{{__('titles.list_unidades')}}</span>
            </a>
        </li>
    </ul>
    </div>
    <div class="col-4 text-right">
        <a href="{{ route('unidade.novo') }}" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> {{ __('labels.add') }}</a>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet__body">
                <div class="tab-content">
                    <input type="hidden" id="columns"
                           value="nome,descricao,created_at,action">

                    <input type="hidden" id="baseurl"
                           value="{{ route('unidades.api-listar') }}">

                    <div class="table-responsive-sm table-responsive-xl">
                        <table class="table table-bordered table-hover table-striped"
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

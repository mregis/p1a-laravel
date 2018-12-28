@extends('layout')

@section('title',  __('titles.agencias'))
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
                <span class="m-nav__link-text">{{__('titles.list_agencias')}}</span>
            </a>
        </li>
    </ul>
    </div>
    <div class="col-4 text-right">
        <a href="{{ route('agencias.novo') }}" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> {{ __('labels.add') }}</a>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet__body">
                <div class="tab-content">
                    <input type="hidden" id="columns"
                           value="codigo,nome,cidade_uf,cd,action">

                    <input type="hidden" id="baseurl"
                           value="{{ route('agencias.api-listar') }}">

                    <div class="table-responsive-sm table-responsive-xl">
                        <table class="table table-bordered table-hover table-striped hasdetails"
                               id="datatable" data-column-defs='[{"targets":[0,5],"orderable":false}]'
                               data-order='[[ 1, "asc" ]]'>
                            <thead class="table-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">{{ __('tables.code') }}</th>
                                <th scope="col">{{ __('tables.name') }}</th>
                                <th scope="col">{{ __('tables.cidade_uf') }}</th>
                                <th scope="col">{{ __('tables.cd') }}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <script id="details-template" type="text/x-handlebars-template">
                        <table class="table" id="check_details">
                            <tr>
                                <td>{{__('tables.address')}}:</td>
                                <td colspan="3">@{{endereco}}</td>
                            </tr>
                            <tr>
                                <td>{{__('tables.zipcode')}}:</td>
                                <td>@{{cep}}</td>
                                <td>{{__('tables.village')}}:</td>
                                <td>@{{bairro}}</td>
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

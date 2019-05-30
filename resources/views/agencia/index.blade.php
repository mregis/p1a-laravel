@extends('layout')

@section('title',  __('titles.agencias'))
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
                                        <h3 class="m-portlet__head-text">Agências</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-12 text-right mb-2">
                                <a href="{{ route('agencias.novo') }}" class="btn btn-lg btn-success"><i
                                            class="fas fa-plus-circle"></i> Nova Agência</a>
                            </div>
                        </div>
                        <input type="hidden" id="columns"
                               value="codigo,nome,cidade_uf,cd,endereco,bairro,cep,created_at,updated_at,action">

                        <input type="hidden" id="baseurl"
                               value="{{ route('agencias.api-listar') }}">

                        <div class="col">
                            <table class="table table-hover table-striped responsive table-responsive compact nowrap"
                                   id="datatable" data-column-defs='[{"targets":[7],"orderable":false}]'
                                   data-order='[[ 1, "asc" ]]'>
                                <thead class="table-dark">
                                <tr>
                                    <th>{{ __('tables.code') }}</th>
                                    <th>{{ __('tables.name') }}</th>
                                    <th>{{ __('tables.cidade_uf') }}</th>
                                    <th>{{ __('tables.cd') }}</th>
                                    <th>{{ __('tables.address') }}</th>
                                    <th>{{ __('tables.village') }}</th>
                                    <th>{{ __('tables.zipcode') }}</th>
                                    <td>{{ __('tables.created_at') }}</td>
                                    <td>{{__('tables.updated_at')}}</td>
                                    <th class="all"></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

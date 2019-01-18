@extends('layout')
@section('title', __('Usuários'))

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
                                        <span class="m-nav__link-text">Usuários</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Listagem de Usuários</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                        <input type="hidden" id="columns" value="id,name,email,profile,action">
                        <input type="hidden" id="baseurl" value="{{ route('users.get_users_list', Auth::id())}}">

                        <table class="table table-striped table-hover hasdetails table-responsive compact nowrap"
                               id="datatable"
                               data-column-defs='[{"targets":[5],"orderable":false}]'
                               data-order='[[ 2, "asc" ]]'
                                >
                            <thead class="thead-dark text-center">
                            <tr>
                                <th></th>
                                <th>{{__('tables.id')}}</th>
                                <th>{{__('tables.name')}}</th>
                                <th>{{__('tables.email')}}</th>
                                <th>{{__('tables.profile')}}</th>
                                <th>{{__('tables.options')}}</th>
                            </tr>
                            </thead>
                        </table>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td class="header">{{__('labels.created_at')}}:</td>
                                    <td>@{{created_at}}</td>
                                    <td class="header">{{__('labels.juncao')}}:</td>
                                    <td>@{{juncao}}</td>
                                </tr>
                                <tr>
                                    <td class="header">{{__('labels.unidade')}}:</td>
                                    <td>@{{unidade}}</td>
                                    <td class="header">{{__('labels.last_login')}}:</td>
                                    <td>@{{last_login}}</td>
                                </tr>
                            </table>
                        </script>
                </div>
            </div>
        </div>
    </div>

@stop

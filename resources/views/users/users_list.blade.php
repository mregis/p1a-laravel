@extends('layout')
@section('title', __('Usuários'))

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
                            <h3 class="m-portlet__head-text">
                                {{__('Listagem')}}
                            </h3>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="columns" value="id,name,email,action">
                <input type="hidden" id="baseurl" value="{{URL::to('/api/users/list')}}">

                <div class="m-portlet__body">
                    <div class="table-responsive-xl">
                        <table class="table"
                               id="datatable">
                            <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>{{__('tables.id')}}</th>
                                <th>{{__('tables.name')}}</th>
                                <th>{{__('tables.email')}}</th>
                                <th>{{__('tables.options')}}</th>
                            </tr>
                            </thead>
                        </table>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td>{{__('labels.name')}}:</td>
                                    <td>@{{name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('labels.email')}}:</td>
                                    <td>@{{email}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('labels.profile')}}:</td>
                                    <td>@{{profile}}</td>
                                </tr>
                            </table>
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

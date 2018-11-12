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
                            <h3 class="m-portlet__head-text">
                                {{__('Listagem')}}
                            </h3>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="columns" value="id,name,total,action">
                <input type="hidden" id="baseurl" value="{{URL::to('/api/upload/list')}}">
                <input type="hidden" id="delete_url" value="{{URL::to('/arquivo/delete')}}">

                <div class="m-portlet__body">
                    <div class="table-responsive-xl">
                        <table class="table"
                               id="datatable">
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
                            <table class="table" id="check_details">
                                <tr>
                                    <td>{{__('labels.name')}}:</td>
                                    <td>@{{name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Total')}}:</td>
                                    <td>@{{total}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Adicionado em')}}:</td>
                                    <td>@{{created_at}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Alterado em')}}:</td>
                                    <td>@{{updated_at}}</td>
                                </tr>
                            </table>
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

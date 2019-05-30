@extends('layout')
@section('title', __('Arquivos'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{__('Listagem')}}
                            </h3>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="columns" value="name,constante,movimento,total,action">
                <input type="hidden" id="baseurl" value="{{route('report.list', Auth::user()->id)}}">

                <div class="m-portlet__body">
                    <table class="table table-striped table-bordered table-responsive compact
                    nowrap hasdetails table-hover text-center"
                           id="datatable" data-column-defs='[{"targets":[0,5],"orderable":false}]'
                           data-order='[[3, "desc"]]'>
                        <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>{{__('tables.name')}}</th>
                            <th>{{__('tables.constante')}}</th>
                            <th>{{__('tables.movimento')}}</th>
                            <th>{{__('tables.total')}}</th>
                            <th>{{__('tables.options')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <script id="details-template" type="text/x-handlebars-template">
                        <table class="table" id="check_details">
                            <tr>
                                <td>{{__('labels.name')}}:</td>
                                <td>@{{name}}</td>
                                <td>{{__('tables.total')}}:</td>
                                <td>@{{total}}</td>
                            </tr>
                            <tr>
                                <td>{{__('labels.created_at')}}:</td>
                                <td>@{{created_at}}</td>
                                <td>{{__('labels.updated_at')}}:</td>
                                <td>@{{updated_at}}</td>
                            </tr>
                        </table>
                    </script>
                </div>
            </div>
        </div>
    </div>

@stop

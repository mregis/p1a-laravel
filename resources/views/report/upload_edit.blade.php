@extends('layout')
@section('title', __('Arquivos'))
@section('styles')
<style type="text/css">
    .m-body .m-content {background-color:#f0f0f0}
</style>
@stop
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
                <input type="hidden" id="columns" value="id,content,status,action">
                <input type="hidden" id="baseurl" value="{{URL::to('/api/report/docs/')}}/{{$id}}">

                <div class="m-portlet__body">
                    <div class="table-responsive-xl">
                        <table class="table table-striped table-bordered dt-responsive nowrap hasdetails"
                               id="datatable" data-column-defs='[{"targets":[4], "orderable":false}]'>
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>{{__('tables.id')}}</th>
                                <th>{{__('Capa Lote')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('tables.options')}}</th>
                            </tr>
                            </thead>
                        </table>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td>{{__('ID do Arquivo')}}:</td>
                                    <td>@{{file_id}}</td>
                                    <td>{{__('Capa Lote')}}:</td>
                                    <td>@{{content}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Adicionado em')}}:</td>
                                    <td>@{{created_at}}</td>
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

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
                <input type="hidden" id="columns" value="id,content,status,action">
                <input type="hidden" id="baseurl" value="{{URL::to('/api/report/docs/')}}/{{$id}}">

                <div class="m-portlet__body">
                    <table class="table table-striped table-bordered nowrap hasdetails text-center
                            table-responsive compact"
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
                        <table class="checkdetails">
                            <tr>
                                <th>{{__('ID do Arquivo')}}:</th>
                                <td>@{{file_id}}</td>
                                <th>{{__('Capa Lote')}}:</th>
                                <td>@{{content}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Adicionado em')}}:</th>
                                <td>@{{created_at}}</td>
                                <th>{{__('Alterado em')}}:</th>
                                <td>@{{updated_at}}</td>
                            </tr>
                        </table>
                    </script>
                </div>
            </div>
        </div>
    </div>

@stop

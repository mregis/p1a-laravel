@extends('layout')
@section('title', __('Arquivos'))

@section('styles')
<style type="text/css">
.m-body .m-content {background-color:#f0f0f0}
@media print {
    html,body{
        margin:0;
        padding:0;
        border:0;
    }
    #printable{
        margin:0;
        padding:0;
        border:0;
        font-size:14px;
    }
    #printable ~ *{
        display:none;
    }
}
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
                <input type="hidden" id="columns" value="id,content,status">
                @if(Auth::user()->juncao)
                <input type="hidden" id="baseurl" value="{{URL::to('/api/upload/report/')}}/{{$id}}/{{Auth::user()->profile}}/{{Auth::user()->juncao}}">
                @else
                <input type="hidden" id="baseurl" value="{{URL::to('/api/upload/report/')}}/{{$id}}/{{Auth::user()->profile}}">
                @endif
                <div class="m-portlet__body">
                    <div class="table-responsive-xl">
                        <table class="table table-striped table-bordered dt-responsive nowrap hasdetails"
                               id="datatable" data-column-defs='[{"targets":[0], "orderable":false}]'>
                            <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>{{__('tables.id')}}</th>
                                <th>{{__('Capa Lote')}}</th>
                                <th>{{__('Status')}}</th>
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
<div class="modal fade" id="modal" tabindex="-1" role="modal" aria-hidden="true" style="min-width:1400px">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="m-widget14__title">Histórico da Capa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div style="background-color:#fff;width:100%;text-align:right;padding:10px">
            Exportar: 
            <a href="javacript:void(0)" id="btnExport"><i class="fa far fa-file-excel"></i></a>
            <a href="javacript:void(0)" id="btnPdf"><i class="fa far fa-file-pdf"></i></a>
            </div>
 
           <table class="table table-bordered" id="history">
                <thead class="table-dark">
                    <th>#CAPA</th>
                    <th>ORIGEM</th>
                    <th>DESTINO</th>
                    <th>REGISTRO</th>
                    <th>DATA</th>
                    <th>USUÁRIO</th>
                    <th>PERFIL</th>
                    <th>LOCAL</th>
                </thead>
                <tbody>
                                                
                </tbody>
                                            
            </table>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop

@section('scripts')
<script type="text/javascript">
    function getHistory(id){
        $.get("/doc/history/"+id,function(r){
            var html = "";
            var created_at = "";
            var unidade = "";
            for(var i in r){
                unidade = "";
                html += "<tr>";
                html += "<td>"+r[i]['content']+"</td>";            
                html += "<td>"+r[i]['origin']+"</td>";
                html += "<td>"+r[i]['dest']+"</td>";
                html += "<td>"+r[i]['register']+"</td>";
                created_at = r[i]['created_at'].split(" ")[0].split("-")[2]+"/"+r[i]['created_at'].split(" ")[0].split("-")[1]+"/"+r[i]['created_at'].split(" ")[0].split("-")[0]+" "+r[i]['created_at'].split(" ")[1];
                html += "<td>"+created_at+"</td>";
                html += "<td>"+r[i]['user']['name']+"</td>";
                html += "<td>"+r[i]['user']['profile']+"</td>";
                unidade = r[i]['user']['unidade'] ? r[i]['user']['unidade'] : r[i]['user']['juncao'];
                html += "<td>"+unidade+"</td>";
                html += "</tr>";            
            }
            
            $('#history tbody').html(html);
        },'json');
        activate();
    }
    function activate(){
    $("#btnExport").click(function(e) {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('history');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        a.download = 'filename.xls';
        a.click();
        e.preventDefault();
    });
    $("#btnPdf").click(function(e) {
        printBy('#history');
    });
    }
    function printBy(selector){
        var $print = $(selector).clone().addClass('print').prependTo('body');
        $('.m-page').hide();
        $('.modal-backdrop').hide();
        window.print();
        $print.remove();
        $('.m-page').show();
        $('.modal-backdrop').show();
    }
</script>
@stop

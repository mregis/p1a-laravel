@extends('layout')
@section('title', __('Receber Envelope'))
@section('styles')
<style type="text/css">
    .m-body .m-content {
        background-color: #f0f0f0
    }

    .details-control {
        display: none
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
                            <h3 class="m-portlet__head-text">{{__('Listagem')}}</h3>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="columns" value="action,content,constante,origem,destino,created_at,updated_at,status">
                @if(Auth::user()->juncao)
                    <input type="hidden" id="baseurl"
                           value="{{URL::to('/api/receber-todos/')}}/{{Auth::user()->profile}}/{{Auth::user()->juncao}}">
                @else
                    <input type="hidden" id="baseurl"
                           value="{{URL::to('/api/receber-todos/')}}/{{Auth::user()->profile}}">
                @endif
                <input type="hidden" id="check_url" value="{{URL::to('/arquivo/recebe')}}">

                <div class="m-portlet__body">
                    <div class="table-responsive-xl">
                        <table class="table table-striped"
                               id="datatable">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th style="width:20px"></th>
                                    <th>{{__('Capa Lote')}}</th>
                                    <th>{{__('Tipo')}}</th>
                                    <th>{{__('Origem')}}</th>
                                    <th>{{__('Destino')}}</th>
                                    <th>{{__('Movimento')}}</th>
                                    <th>{{__('Ultima Atualização')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                            </thead>
                        </table>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td>@{{confirm}}</td>
                                    <td>@{{content}}</td>
                                </tr>
                            </table>
                        </script>
                    </div>
                    <div class="row">
                        <div class="m-form__actions">
                            <input class="btn btn-success" type="submit" onclick="save()"
                                   value="Receber" style="width:100%;max-width:150px;text-transform:uppercase">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="modal" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%">
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

                <table class="table table-bordered table-striped table-compact" id="history">
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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>

    <script type="text/javascript">
        function allCheck(elem) {
            if ($('#all_lote').prop('checked') == true) {
                $('.input-doc').prop('checked', true);
            } else {
                $('.input-doc').prop('checked', false);
            }
        }
        function save() {
            if (confirm('Deseja receber ' + $('.input-doc:checked').length + ' capas de lote?')) {
                var doc = [];
                var c = 0;
                var user = '{{ Auth::user()->id }}';
            }
            $('.input-doc').each(function () {
                if ($(this).prop('checked') == true) {
                    doc[c++] = $(this).val();
                }
            });
            $.post('/api/receber/registrar', {doc: doc, user: user}, function (r) {
                location.reload();
            });
        }

        function getHistory(id){
            $('#history tbody').html('');
            $.get("/doc/history/"+id, function(r) {
                var html = "";
                var created_at = "";
                var unidade = "";
                for(var i in r) {
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
            }, 'json').fail(function(r){
                alert('Ocorreu um erro ao tentar recuperar as informações requisitadas.');

            });
            activate();
        }
        function activate(){
            $("#btnExport").click(function(e) {
                var a = document.createElement('a');
                var data_type = 'data:application/vnd.ms-excel';
                var table_div = document.getElementById('history');
                var table_html = table_div.outerHTML.replace(/ /g, '%20');
                a.href = data_type + ', ' + table_html;
                a.download = 'filename.xlsx';
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

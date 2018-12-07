@extends('layout')
@section('title', __('Remessa'))

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
                                {{__('Registrar Remessa')}}
                            </h3>
                        </div>
                    </div>
                </div>

				<input type="hidden" id="columns" value='action,content,constante,origem,destino,created_at,updated_at,status,view'>
				<input type="hidden" id="baseurl" value="{{URL::to('/api/remessa/registrar/')}}/{{Auth::user()->id}}">
                <input type="hidden" id="check_url" value="{{URL::to('/remessa/registrar')}}">
				<div class="m-portlet__body">
					<div class="table-responsive-xl">
						<table class="table table-striped table-bordered dt-responsive nowrap"
                               id="datatable"
                               data-order='[[6, "desc"], [1, "asc"]]'
                               data-column-defs='[{"targets":[0,8],"orderable":false, "searchable":false}]'>
							<thead class="thead-dark">
							<tr>
								<th>
									<input type="checkbox" name="all_lote" class="form-control m-input"
										   onclick="allCheck(this);" id="all_lote" style="width:20px">
								</th>
								<th>{{__('Capa Lote')}}</th>
								<th>{{__('Tipo')}}</th>
								<th>{{__('Origem')}}</th>
								<th>{{__('Destino')}}</th>
								<th>{{__('Movimento')}}</th>
                                <th>{{__('tables.updated_at')}}</th>
								<th>{{__('Status')}}</th>
								<th>{{__('Detalhes')}}</th>
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
							<button class="btn btn-lg btn-success" data-toggle="modal" data-target="#receberModal">
                                Registrar</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="receberModal" tabindex="-1" role="modal" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="m-widget14__title">Confirmar Registro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <h3 class="m-portlet__head-text"> Lacre Malote</h3><br>
                    <input type="text" name="lacre" class="form-control m-input" id="lacre" style="max-width:150px;text-transform:uppercase"><br>
                    <div class="m-form__actions">
                        <button class="btn btn-success btn-lg" onclick="save()">Registrar</button>
                        <button class="btn btn-primary btn-lg" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="capaLoteHistoryModal" tabindex="-1" role="modal" aria-hidden="true">
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@stop

@section('scripts')
<script type="text/javascript">
function allCheck(elem){
	$('.input-doc').prop('checked', $('#all_lote').prop('checked') == true);
}
function save(){
    if ($('.input-doc:checked').length > 0) {
            var lacre = $('#lacre').val().toUpperCase();
            var doc = [];
            var c = 0;
            var user = {{ Auth::user()->id }};
            $('.input-doc').each(function () {
                if ($(this).prop('checked') == true) {
                    doc[c++] = $(this).val();
                }
            });
            $.post('/api/remessa/registrar', {lacre: lacre, doc: doc, user: user}, function (r) {
                // Close all opened modals
                $('.modal').modal('hide');
                var successmodal = $("#on_done_data").modal();
                successmodal.find('.modal-body').find('p').text(r);
                successmodal.show();
                $('#datatable').DataTable().ajax.reload();
            }).fail(function(f) {
                // Close all opened modals
                $('.modal').modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p').text(f.responseText);
                errormodal.show();
            });

    } else {
        // Close all opened modals
        $('.modal').modal('hide');
        var errormodal = $("#on_error").modal();
        errormodal.find('.modal-body')
                .find('p')
                .text('É necessário selecionar ao menos 1 capa de malote.');
        errormodal.show();
    }

}

function getHistory(id) {
    $('#history tbody').html('');
    $.get("/doc/history/" + id, function (r) {
        var html = "";
        var created_at = "";
        var unidade = "";
        for (var i in r) {
            unidade = "";
            html += "<tr>";
            html += "<td>" + r[i]['content'] + "</td>";
            html += "<td>" + r[i]['origin'] + "</td>";
            html += "<td>" + r[i]['dest'] + "</td>";
            html += "<td>" + r[i]['register'] + "</td>";
            created_at = r[i]['created_at'].split(" ")[0].split("-")[2] + "/" + r[i]['created_at'].split(" ")[0].split("-")[1] + "/" + r[i]['created_at'].split(" ")[0].split("-")[0] + " " + r[i]['created_at'].split(" ")[1];
            html += "<td>" + created_at + "</td>";
            html += "<td>" + r[i]['user']['name'] + "</td>";
            html += "<td>" + r[i]['user']['profile'] + "</td>";
            unidade = r[i]['user']['unidade'] ? r[i]['user']['unidade'] : r[i]['user']['juncao'];
            html += "<td>" + unidade + "</td>";
            html += "</tr>";
        }

        $('#history tbody').html(html);
    }, 'json').fail(function (r) {
        alert('Ocorreu um erro ao tentar recuperar as informações requisitadas.');

    });
    activate();
}
function activate() {
    $("#btnExport").click(function (e) {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('history');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        a.download = 'filename.xlsx';
        a.click();
        e.preventDefault();
    });
    $("#btnPdf").click(function (e) {
        printBy('#history');
    });
}
function printBy(selector) {
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

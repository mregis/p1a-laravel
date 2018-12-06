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

				<input type="hidden" id="columns"
                       value='action,content,constante,origem,destino,created_at,updated_at,status'>
				<input type="hidden" id="baseurl" value="{{URL::to('/api/remessa/registrar/')}}/{{Auth::user()->id}}">
                <input type="hidden" id="check_url" value="{{URL::to('/remessa/registrar')}}">
				<div class="m-portlet__body">
					<div class="table-responsive-xl">
						<table class="table table-striped" id="datatable"
                               data-column-defs='[{"targets": [1],"orderable": false}]'
                               >
							<thead class="thead-dark">
							<tr>
                                <th></th>
								<th style="width:20px" class="nosort">
									<input type="checkbox" name="all_lote" class="form-control m-input"
										   onclick="allCheck(this);" id="all_lote">
								</th>
								<th>{{__('Capa Lote')}}</th>
								<th>{{__('Tipo')}}</th>
								<th>{{__('Origem')}}</th>
								<th>{{__('Destino')}}</th>
								<th>{{__('Movimento')}}</th>
                                <th>{{__('tables.updated_at')}}</th>
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
                    <h4 class="m-widget14__title">Confirmar de Recebimento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <h3 class="m-portlet__head-text"> Lacre Malote</h3><br>
                    <input type="text" name="lacre" class="form-control m-input" id="lacre" style="max-width:150px;text-transform:uppercase"><br>
                    <div class="m-form__actions">
                        <button class="btn btn-success btn-lg" onclick="save()">Receber</button>
                        <button class="btn btn-primary btn-lg">Cancelar</button>
                    </div>
                </div>
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
    if(confirm('Deseja registrar a remessa ?')){
        var lacre = $('#lacre').val().toUpperCase();
        var doc = [];
        var c = 0;
        var user = {{ Auth::user()->id }};
        $('.input-doc').each(function(){
            if($(this).prop('checked') == true){
                doc[c++] = $(this).val();
            }
        });
        $.post('/api/remessa/registrar',{lacre:lacre,doc:doc,user:user},function(r){
            location.reload();
        });
    }
}
</script>
@stop

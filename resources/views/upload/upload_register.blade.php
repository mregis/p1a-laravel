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
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">Remessa (Envio)</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h4 class="m-portlet__head-text">Registrar Remessa</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

				<input type="hidden" id="columns" value='action,content,constante,from_agency,to_agency,created_at,updated_at,status,view'>
				<input type="hidden" id="baseurl" value="{{URL::to('/api/remessa/registrar/')}}/{{Auth::user()->id}}">
                <input type="hidden" id="check_url" value="{{URL::to('/remessa/registrar')}}">
				<div class="m-portlet__body">
                    <table class="table table-striped table-bordered nowrap table-responsive compact text-center"
                               id="datatable"
                               data-order='[[4, "asc"], [5, "asc"]]'
                               data-column-defs='[{"targets":[0,7,8],"orderable":false, "searchable":false}]'>
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
						<div class="m-form__actions">
							<button class="btn btn-lg btn-success" data-toggle="modal" data-target="#receberModal">
                                <i class="fas fa-file-download"></i> Registrar</button>
						</div>
				</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="receberModal" tabindex="-1" role="modal" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="m-widget14__title">Confirmar Envio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <h3 class="m-portlet__head-text">Informar Lacre (Opcional)</h3><br>
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

    @component('dochistory')
    @endcomponent
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


</script>
@stop

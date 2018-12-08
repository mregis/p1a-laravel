@extends('layout')
@section('title', __('Recebimento'))

@section('styles')
<style type="text/css">
.div-malote{clear:both;height:40px}
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
                                {{__('Operador')}}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-md-6 col-xl-6">
					<h3 class="m-portlet__head-text">Capa de Lote #</h3><hr>
					<div class="div-malote"><input type="text" name="malote[]" class=" m-input input-doc" style="max-width:150px;height:35px;border:1px solid #ccc"> <a href="javascript:void(0)" class="plus btn btn-success" onclick="$('.div-malote:last').show()">+</a></div>
					<div class="div-malote" style="display:none"><input type="text" name="malote[]" class="m-input input-doc" style="max-width:150px;height:35px;border:1px solid #ccc"> <a href="javascript:void(0)" class="plus btn btn-success" onclick="addCapa(this)">+</a> <a href="javascript:void(0)" onclick="$(this).parent().hide();$('.m-input',$(this).parent()).val('')" class="minus btn btn-danger">-</a></div>
				</div>
				<div class="col-md-6 col-xl-6" style="padding:20px">
					<h3 class="m-portlet__head-text"> Lacre Malote</h3><br>
					<input type="text" name="lacre" class="form-control m-input" id="lacre" style="max-width:150px"><br>
					<div class="m-form__actions">
						<input class="btn btn-success" type="submit" onclick="saveCapa()" value="Registrar" style="width:100%;max-width:150px">
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
function addCapa(elem){
	var bloco = $(elem).parent().clone();
	$(elem).parent().after(bloco);
}
function saveCapa(){
	var x = 0
	var lacre = $('#lacre').val().toUpperCase();
	$('.input-doc').each(function(){
		if($(this).val().length > 0) x++;
	});
	if(confirm('Deseja confirmar o recebimento de '+x+' capas de lote com o lacre número '+lacre+' ?')){
		var doc = [];
		var c = 0;
		var user = {{{ Auth::user()->id }}};
		$('.input-doc').each(function(){
			if($(this).val().length > 0)
			doc[c++] = $(this).val();
		});
		$.post('/api/receber/registraroperador', {lacre:lacre,doc:doc,user:user}, function(r) {
            $('#datatable').DataTable().ajax.reload();
		});
	}
}

</script>
@stop

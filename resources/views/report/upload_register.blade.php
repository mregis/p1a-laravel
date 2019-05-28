@extends('layout')
@section('title', __('Remessa'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">Registrar Remessa</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-md-6 col-xl-6">
					<h3 class="m-portlet__head-text">Capa de Lote #</h3><hr>
					<div class="row">
						<label style="font-size:22px;min-width: 200px;padding:0 0 0 20px"><span style="float:left;width:150px">Todos</span> <input style="float:left;width:20px;margin: 11px 0 0 0;" type="checkbox" name="all_lote" class="form-control m-input" onclick="return allCheck(this)" id="all_lote"></label>
					</div>
					@foreach($docs as &$doc)
					<div class="row">
						<label style="font-size:18px;min-width: 200px;padding:0 0 0 20px"><span style="float:left;width:150px">{{$doc->content}}</span> <input style="float:left;width:20px;margin: 6px 0 0 0;" type="checkbox" name="lote[]" class="form-control m-input input-doc" value="{{$doc->id}}"></label>
					</div>
					@endforeach
				</div>
				<div class="col-md-6 col-xl-6" style="padding:20px">
					<h3 class="m-portlet__head-text"> Lacre Malote</h3><br>
					<input type="text" name="lacre" class="form-control m-input" id="lacre" style="max-width:150px;text-transform:uppercase"><br>
					<div class="m-form__actions">
						<input class="btn btn-success" type="submit" onclick="save()" value="Registrar" style="width:100%;max-width:150px;text-transform:uppercase">
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
function allCheck(elem){
	var t = $('#all_lote').prop('checked') == true;
	$('.input-doc').prop('checked', t);
}
function save(){
	if (confirm('Deseja registrar a remessa ?')) {
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
			$('#datatable').DataTable().ajax.reload();
		});
	}
}
</script>
@stop

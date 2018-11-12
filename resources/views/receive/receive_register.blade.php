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

                <div class="m-portlet__body">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-md-6 col-xl-6">
					<h3 class="m-portlet__head-text">Capa de Lote #</h3><hr>
					<div class="row">
						<label style="font-size:22px;min-width: 200px;padding:0 0 0 20px"><span style="float:left;width:150px">Todos</span> <input style="float:left;width:20px;margin: 11px 0 0 0;" type="checkbox" name="lote[]" class="form-control m-input"></label>
					</div>
				</div>
				<div class="col-md-6 col-xl-6" style="padding:20px">
					<h3 class="m-portlet__head-text"> Lacre Malote</h3><br>
					<input type="text" name="lacre" class="form-control m-input" id="lacre" style="max-width:150px"><br>
					<div class="m-form__actions">
						<input class="btn btn-success" type="submit" value="Registrar" style="width:100%;max-width:150px">
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>
    </div>

@stop

@extends('layout')
@section('title', __('Remessa'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
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
						<label><span>Todos</span> <input type="checkbox" name="lote[]" class="form-control m-input"></label>
					</div>
				</div>
				<div class="col-md-6 col-xl-6">
					<h3 class="m-portlet__head-text"> Lacre Malote</h3><br>
					<input type="text" name="lacre" class="form-control m-input" id="lacre"><br>
					<div class="m-form__actions">
						<input class="btn btn-success btn-lg" type="submit" value="Registrar">
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>
    </div>

@stop

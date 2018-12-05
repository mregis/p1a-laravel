@extends('layout')

@section('title',  __('Receber Lotes'))
@section('content')
<style type="text/css">
.m-body .m-content {background-color:#f0f0f0}
</style>
<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
	<li class="m-nav__item m-nav__item--home">
		<a href="/dashboard" class="m-nav__link m-nav__link--icon">
			<i class="m-nav__link-icon la la-home"></i>
		</a>
	</li>
	<li class="m-nav__separator">-</li>
	<li class="m-nav__item">
		<a href="javascript:void(0)" class="m-nav__link">
			<span class="m-nav__link-text">{{__('Receber Lotes')}}</span>
		</a>
	</li>
</ul>

<div class="row">
	<div class="col-md-12">
		<div class="m-portlet m-portlet--tabs">
			<div class="m-portlet__head"><br><h3>Recebimento</h3></div>
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th>Nome</th>
								<th>Total</th>
								<th>Pendentes</th>
								<th>Data Upload</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							@foreach($files as &$f)
							<tr>
								<td>{{$f->name}}</td>
								<td>{{$f->total}}</td>
								<td>{{$f->pendentes}}</td>
								<td>{{\Carbon\Carbon::parse($f->updated_at)->format('d/m/Y H:i:s')}}</td>
								<td><a href="/receber/{{$f->id}}" data-toggle="tooltip" title="Ver" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fas fa-eye"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>
@stop

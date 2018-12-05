@extends('layout')

@section('title',  __('titles.alerts'))
@section('content')

<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
                <a href="/dashboard" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
                <a href="javascript:void(0)" class="m-nav__link">
                        <span class="m-nav__link-text">Cadastros</span>
                </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
                <a href="javascript:void(0)" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('titles.list_alerts')}}</span>
                </a>
        </li>
</ul>
<div class="row">
<div class="col-md-12" style="background-color:#fff">

<div class="m-portlet__body">
<div class="tab-content">

	<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
		<thead>
			<tr>
				<th scope="col">Data</th>
				<th scope="col">Hora</th>
				<th scope="col">Usuário</th>
				<th scope="col">Pefil</th>
				<th scope="col">Localidade</th>
				<th scope="col">Operação</th>
				<th scope="col">Obs</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
		@foreach($alerts as $a)
		<tr>
			<td scope="row">{{\Carbon\Carbon::parse($a->date_ref)->format('d/m/Y')}}</td>
			<td scope="row">{{$a->time_ref}}</td>
			<td scope="row">{{$a->user['name']}}</td>
			<td scope="row">{{$a->user['profile']}}</td>
			<td scope="row">{{$a->user['unidade']}}</td>
			<td scope="row">{{$a->tipo}}</td>
			<td scope="row">{{$a->desc}}</td>
			<td class="text-center">
				<a href="/ocorrencias/edit/{{$a->id}}" data-toggle="tooltip" title="{{__('buttons.edit')}}" class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only"><i class="fas fa-pencil-alt"></i></a>
				<a href="/ocorrencias/remove/{{$a->id}}" data-toggle="tooltip" title="{{__('buttons.delete')}}" onclick="if(confirm('Deseja remover esse registro ?')){return true;}else{return false;}" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only"><i class="fas fa-times"></i></a>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

@stop

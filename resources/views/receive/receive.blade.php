@extends('layout')

@section('title',  __('Receber Lotes'))

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
			<span class="m-nav__link-text">{{__('Receber Lotes')}}</span>
		</a>
	</li>
</ul>

<div class="row">
	<div class="col-md-12">
		<div class="m-portlet m-portlet--tabs">
			<div class="m-portlet__head"><br><h3>Recebimento</h3></div>
			<div class="m-portlet__body">
                <input type="hidden" id="columns" value="name,total,pendentes,movimento,view">
                <input type="hidden" id="baseurl" value="{{ route('receive.lista-arquivos',Auth::user()->id)}}">
                <div class="table-responsive-sm table-responsive-xl">
					<table class="table table-striped table-bordered table-hover"
						   id="datatable"
                           data-column-defs='[{"targets":[4],"orderable":false}]'
						   data-order='[[3, "asc"],[2, "desc"]]'
							>
						<thead class="thead-dark">
							<tr>
								<th>{{ __('tables.name') }}</th>
								<th>{{ __('tables.total') }}</th>
								<th>{{ __('tables.pendentes') }}</th>
								<th>{{ __('tables.movimento') }}</th>
								<th>{{ __('tables.details') }}</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

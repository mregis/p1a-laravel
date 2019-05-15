@extends('layout')

@section('title',  __('Receber Lotes'))

@section('content')

<div class="row">
	<div class="col-12">
		<div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                            <li class="m-nav__item m-nav__item--home">
                                <a href="{{route('home')}}" class="m-nav__link m-nav__link--icon">
                                    <i class="m-nav__link-icon la la-home"></i>
                                </a>
                            </li>
                            <li class="m-nav__separator">-</li>
                            <li class="m-nav__item">
                                <a href="javascript:void(0)" class="m-nav__link">
                                    <span class="m-nav__link-text">Recebimento</span>
                                </a>
                            </li>
                            <li class="m-nav__separator">-</li>
                            <li class="m-nav__item">
                                <a href="javascript:void(0)" class="m-nav__link">
                                    <h3 class="m-portlet__head-text">{{__('Receber Lotes')}}</h3>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

			<div class="m-portlet__body">

                <input type="hidden" id="columns" value="name,total,pendentes,movimento,view">
                <input type="hidden" id="baseurl" value="{{ route('receive.lista-arquivos',Auth::user()->id)}}">
					<table class="table table-striped table-hover text-center table-responsive compact nowrap"
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
@stop

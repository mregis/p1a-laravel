@extends('layout')

@section('title',  __('titles.alerts'))
@section('content')


	<div class="row">
		<div class="col-md-12">
			<div class="m-portlet m-portlet--tabs">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
							<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
								<li class="m-nav__item m-nav__item--home">
									<a href="{{route('home')}}" class="m-nav__link m-nav__link--icon">
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
										<h3 class="m-portlet__head-text">{{__('titles.alerts')}}</h3>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="m-portlet m-portlet--tabs">
					<div class="m-portlet__head">
						<div class="m-portlet__head-tools">
							<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x"
								role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_2"
                                       role="tab">
                                        <i class="la la-eye"></i>Listagem de Ocorrências
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
									<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_1"
									   role="tab">
										<i class="la la-plus-circle"></i> Adicionar Ocorrência
									</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="m-portlet__body">
						<div class="tab-content">
                            <div class="tab-pane active" id="m_tabs_6_2" role="tabpanel">
                                <table class="table table-bordered m-table
                                    m-table--head-bg-brand text-center table-striped
                                    table-responsive compact">
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">{{__('tables.created_at')}}</th>
                                        <th scope="col">{{__('labels.user')}}</th>
                                        <th scope="col">{{__('labels.profile')}}</th>
                                        <th scope="col">{{__('tables.local')}}</th>
                                        <th scope="col">{{__('labels.description')}}</th>
                                        <th scope="col">{{__('labels.history')}}</th>
                                        <th scope="col">{{__('tables.created_at')}}</th>
                                        <th scope="col">{{__('tables.updated_at')}}</th>
                                        <th scope="col">{{__('tables.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($alerts as $i => $a)
                                        <tr class="{{ ( $i % 2 == 0 ? 'even' : 'odd')}}">
                                            <td scope="row">{{\Carbon\Carbon::parse($a->created_at)->format('d/m/Y H:i')}}</td>
                                            <td scope="row">{{$a->user->name}}</td>
                                            <td scope="row">{{$a->user->profile}}</td>
                                            <td scope="row">{{$a->user->getLocal()}}</td>
                                            <td scope="row">{{$a->description}}</td>
                                            <td scope="row">{{$a->content}}</td>
                                            <td scope="row">{{\Carbon\Carbon::parse($a->created_at)->format('d/m/Y H:i')}}</td>
                                            <td scope="row">{{\Carbon\Carbon::parse($a->updated_at)->format('d/m/Y H:i')}}</td>
                                            <td class="text-center">
                                                <a href="{{ route('cadastros.edit_alert', $a->id) }}"
                                                   data-toggle="tooltip"
                                                   title="{{__('buttons.edit')}}"
                                                   class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a href="{{ route('cadastros.delete_alert', $a->id) }}" data-toggle="tooltip"
                                                   title="{{__('buttons.delete')}}"
                                                   onclick="if(confirm('Deseja remover esse registro ?')){return true;}else{return false;}"
                                                   class="btn btn-danger btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

							<div class="tab-pane" id="m_tabs_6_1" role="tabpanel">
								<div class="col-md-12">
									<div class="m-portlet m-portlet--tab">
                                        {{ Form::open(array('url' => url('api/alerts'),
                                            'class'=>'m-form m-form--fit m-form--label-align-right ajax-form')) }}

										@if ($errors->any())
											<div class="alert alert-danger">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-3">
													<label for="product">Produto</label>
                                                    <select class="form-control form-control-lg m-input
                                                        m-input--square{{$errors->has('product') ? ' is-invalid' : ''}}"
                                                            name="product" id="product" required="required"
                                                            data-validation="notempty($(this))">
                                                        <option value="">{{__('labels.select')}}</option>
                                                        @foreach($products as $p)
                                                        <option value="{{$p->id}}">{{$p->description}}</option>
                                                        @endforeach
                                                    </select>
												</div>
                                                <div class="col-3">
                                                    <label for="type">{{__('tables.type')}}</label>
                                                    <select class="form-control form-control-lg m-input
                                                        m-input--square{{$errors->has('type') ? ' is-invalid' : ''}}"
                                                            name="type" id="type" required="required"
                                                            data-validation="notempty($(this))">
                                                        <option value="">{{__('labels.select')}}</option>
                                                        @foreach($ocorrencia_types as $t)
                                                            <option value="{{$t}}">{{$t}}</option>
                                                        @endforeach
                                                            <option value="outro">Outro</option>
                                                    </select>
                                                </div>
                                                <div class="col-5">
                                                    <label for="content">{{__('labels.title')}}</label>
                                                    <input class="form-control form-control-lg m-input
                                                        m-input--square{{$errors->has('content') ? ' is-invalid' : ''}}"
                                                            name="content" id="content" required="required"
                                                            data-validation="notempty($(this))" />
                                                </div>
											</div>
											<div class="form-group m-form__group row">
												<div class="col-6">
													<label for="description">{{__('titles.historic')}}</label>
                                                    <textarea rows="3" class="form-control form-control-lg m-input{{$errors->has('descricao') ? ' is-invalid' : ''}}"
															  name="description" id="description"
															  data-validation="notempty($(this))"
															  data-label="{{__('labels.description')}}"
															  data-error="{{__('labels.field_not_empty')}}"
															>@if(isset($alert) && $alert->descricao){{$alert->descricao}}@endif</textarea>
												</div>
											</div>
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												{{ Form::submit(__('buttons.submit'), array('class' => 'btn btn-success btn-lg')) }}
												<button type="reset" class="btn btn-lg btn-outline-secondary">
                                                    {{__('buttons.cancel')}}</button>
											</div>
										</div>
                                        <input type="hidden" name="_u" value="{{ Auth::id() }}" />
										{{ csrf_field() }}
										{{ Form::close() }}
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop

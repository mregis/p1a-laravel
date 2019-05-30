@extends('layout')

@section('title',  __('titles.alerts'))
@section('content')

    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--tab">
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
                                        <h3 class="m-portlet__head-text">Cadastro de Ocorrência</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <h4 class="m-portlet__head-text"><i class="fas fa-plus-circle"></i> Cadastro de Ocorrências</h4>
                    </div>
                </div>
                <div class="m-portlet__body">
                    {{ Form::open(array('url' => url('api/alerts'), 'class'=>'m-form m-form--fit m-form--label-align-right ajax-form')) }}
                    <div class="form-group m-form__group row">
                        <div class="col-md-4">
                            <label for="name">Data da Ocorrência</label>
                            <input type="text" class="form-control form-control-lg m-input"
                                   name="date_ref" id="date_ref" data-validation="notempty($(this))"
                                   data-label="Data da Ocorrência"
                                   data-error="{{__('labels.field_not_empty')}}"
                                   placeholder="Data da Ocorrência">
                        </div>
                        <div class="col-md-3">
                            <label for="name">Hora da Ocorrência</label>
                            <input type="text" class="form-control form-control-lg m-input"
                                   name="time_ref" id="time_ref" data-validation="notempty($(this))"
                                   data-label="Hora da Ocorrência"
                                   data-error="{{__('labels.field_not_empty')}}"
                                   placeholder="Hora da Ocorrência">
                        </div>
                        <div class="col-md-5">
                            <label for="type">{{__('labels.type')}} de Ocorrência</label>
                            <input type="text" class="form-control form-control-lg m-input"
                                   name="tipo"
                                   id="tipo" data-validation="notempty($(this))"
                                   data-label="{{__('labels.type')}}"
                                   data-error="{{__('labels.field_not_empty')}}"
                                   placeholder="{{__('labels.type')}}">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6">
                            <label for="description">Observação</label>
                                        <textarea rows="3" class="form-control form-control-lg m-input" name="desc"
                                                  id="desc"
                                                  data-validation="notempty($(this))"
                                                  data-label="{{__('labels.bank_name')}}"
                                                  data-error="{{__('labels.field_not_empty')}}"
                                                  placeholder="{{__('labels.description')}}"></textarea>
                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            {{ Form::submit(__('buttons.submit'), array('class' => 'btn btn-lg btn-success')) }}
                            <button type="reset" class="btn btn-lg btn-outline-secondary"
                                    onclick="window.history.back()">{{__('buttons.cancel')}}</button>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    {{ csrf_field() }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#date_ref').datepicker($.extend(datepickerConfig, {value: '{{date('d/m/Y', strtotime('-3 days'))}}'}));
            $("#time_ref").timepicker(timepickerConfig);
        });
    </script>

@stop

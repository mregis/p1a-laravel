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
                        <span class="m-nav__link-text">{{__('titles.add_alerts')}}</span>
                </a>
        </li>
</ul>


<div class="row">
<div class="col-md-12">

<div class="m-portlet__body">
  <div class="tab-content">
     <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">

        <div class="col-md-12">

            <div class="m-portlet m-portlet--tab">

                <div class="m-portlet__head">

                    <div class="m-portlet__head-caption">


                        <div class="m-portlet__head-title">

                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <h3 class="m-portlet__head-text">
                                {{__('titles.add_alerts')}}
                            </h3>
                        </div>

                    </div>
                </div>
                {{ Form::open(array('url' => url('api/alerts'), 'class'=>'m-form m-form--fit m-form--label-align-right ajax-form')) }}
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-md-4">
                            <label for="name">Data da Ocorrência</label>
                            <input type="text" class="form-control m-input datepicker" name="date_ref" id="date_ref" data-validation="notempty($(this))" data-label="Data da Ocorrência" data-error="{{__('labels.field_not_empty')}}" placeholder="Data da Ocorrência">
                        </div>
                        <div class="col-md-3">
                            <label for="name">Hora da Ocorrência</label>
                            <input type="text" class="form-control m-input datepicker2" name="time_ref" id="time_ref" data-validation="notempty($(this))" data-label="Hora da Ocorrência" data-error="{{__('labels.field_not_empty')}}" placeholder="Hora da Ocorrência">
                        </div>
                        <div class="col-md-5">
                            <label for="type">{{__('labels.type')}} de Ocorrência</label>
                            <input type="text" class="form-control m-input" name="tipo" id="tipo" data-validation="notempty($(this))" data-label="{{__('labels.type')}}" data-error="{{__('labels.field_not_empty')}}" placeholder="{{__('labels.type')}}">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6">
                            <label for="description">Observação</label>
                            <textarea rows="1" class="form-control m-input" name="desc" id="desc"
                                      data-validation="notempty($(this))" data-label="{{__('labels.bank_name')}}"
                                      data-error="{{__('labels.field_not_empty')}}"
                                      placeholder="{{__('labels.description')}}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        {{ Form::submit(__('buttons.submit'), array('class' => 'btn btn-success')) }}
                        <button type="reset" class="btn btn-secondary"
                                onclick="window.history.back()">{{__('buttons.cancel')}}</button>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="{{{ Auth::user()->id }}}">
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
<script type="text/javascript">
setTimeout(function(){
$( document ).ready(function() {
	$('.datepicker').datepicker({format: 'dd/mm/yyyy', startDate: '-3d'});
	$(".datepicker2").mask("99:99");
});
},1000);
</script>
@stop

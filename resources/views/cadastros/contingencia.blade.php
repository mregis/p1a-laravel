@extends('layout')

@section('title',  __('Contingência'))
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
                        <span class="m-nav__link-text">{{__('Contingência')}}</span>
                </a>
        </li>
</ul>


<div class="row">
<div class="col-md-12">
<div class="m-portlet m-portlet--tabs">

<div class="m-portlet__body">

        <div class="col-md-12">

            <div class="m-portlet m-portlet--tab">

                <div class="m-portlet__head">

                    <div class="m-portlet__head-caption">


                        <div class="m-portlet__head-title">

                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <h3 class="m-portlet__head-text">
                                {{__('Gerar Capa por Contingência')}}
                            </h3>
                        </div>

                    </div>
                </div>
                {{ Form::open(array('url' => url('api/contingencia'), 'class'=>'m-form m-form--fit m-form--label-align-right ajax-form')) }}
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-md-4">
                            <label for="type">Agência Destino</label>
                            <input type="text" class="form-control m-input" name="agency" id="agency" data-validation="notempty($(this))" data-label="{{__('labels.type')}}" data-error="{{__('labels.field_not_empty')}}" placeholder="Agência" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="mod">Tipo de Documento</label>
                            <select class="form-control m-input m-input--square" name="type" id="type" data-validation="notempty($(this))">
                                <option disabled selected>{{__('labels.select')}}</option>
                                <option value="documento" @if(isset($produto) && $produto->mod == 'documento') selected @endif;>Documento</option>
                                <option value="produto" @if(isset($produto) && $produto->mod == 'produto') selected @endif;>Produto</option>
                            </select>
                        </div>


                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        {{ Form::submit(__('GERAR CAPA'), array('class' => 'btn btn-success')) }}
                        <button type="reset" class="btn btn-secondary"
                                onclick="window.history.back()">{{__('buttons.cancel')}}</button>
                    </div>
                </div>
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

@stop

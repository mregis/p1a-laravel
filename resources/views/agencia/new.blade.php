@extends('layout')
@section('title', __('titles.agencia'))

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
                                        <span class="m-nav__link-text">Cadastros</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">{{__('titles.add_agencia')}}</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon"><i class="fas fa-plus-square"></i></span>

                            <h3 class="m-portlet__head-text">Adicionar Nova Agência </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    {{ Form::model($agencia, array('url' => route('agencias.novo'),
                                                    'method' => 'POST', 'id'=>'form_agencia', 'name'=>'form_agencia',
                                                    'class'=>'m-form m-form--fit'
                                                    )) }}
                    <input type="hidden" name="_method" value="put"/>
                    @component('forms/agencia', ['agencia' => $agencia]);
                    @endcomponent

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <a class="btn btn-outline-secondary btn-lg"
                               href="{{route('cadastro.agencias')}}">Cancelar</a>
                            {{ Form::submit(__('Salvar'), array('class' => 'btn btn-success btn-lg')) }}
                        </div>
                    </div>

                    @csrf
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop

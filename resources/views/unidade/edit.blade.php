@extends('layout')
@section('title', __('titles.unidade'))

@section('content')

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon">
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
                <span class="m-nav__link-text">{{__('titles.edit_unidade')}}</span>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon"><i class="fas fa-new"></i></span>
                            <h3 class="m-portlet__head-text">Editar Unidade <span class="badge badge-primary">{{ $unidade->nome }}</span> </h3>
                        </div>
                    </div>
                </div>
                <div>
                    {{ Form::model($unidade, array('url' => route('unidade.api-atualizar',$unidade->id),
                        'method' => 'PUT', 'class'=>'m-form m-form--fit ajax-form')) }}
                    @component('forms/unidade', ['unidade' => $unidade]);
                    @endcomponent
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <a class="btn btn-primary btn-lg" href="{{route('unidades.index')}}">Cancelar</a>
                            {{ Form::submit(__('Atualizar Cadastro'), array('class' => 'btn btn-success btn-lg')) }}
                        </div>
                    </div>
                    @csrf
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop

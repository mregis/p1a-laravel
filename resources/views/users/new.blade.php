<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 03/01/2019
 * Time: 12:58
 */
?>
@extends('layout')

@section('title',  __('titles.users'))

@section('styles')
    <style type="text/css">
    .empty-message {
        padding: 5px 10px;
        text-align: center;
    }
    </style>
@stop
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
            <span class="m-nav__link-text">{{__('titles.add_users')}}</span>
        </a>
    </li>
</ul>

<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon"><i class="fas fa-plus-square"></i></span>
                        <h3 class="m-portlet__head-text">Adicionar Novo Usuário</h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                {{ Form::model($usuario, array('url' => route('users.users_save'),
                    'method' => 'POST', 'id' => 'form_usuario', 'name' => 'form_usuario',
                    )) }}
                @component('forms/users', [
                    'usuario' => $usuario, 'perfis' => $perfis, 'unidades' => $unidades,
                    'errors' => $errors
                    ]);
                @endcomponent
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <a class="btn btn-primary btn-lg" href="{{route('users.users_index')}}">Cancelar</a>
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


@extends('layout')
@section('title', __('titles.users'))

@section('content')

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon fas fa-home"></i>
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
                <span class="m-nav__link-text">{{__('titles.edit_user')}}</span>
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
                            <h3 class="m-portlet__head-text">Editar Usuário <span class="badge badge-primary">{{ $usuario->name }}</span> </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    {{ Form::model($usuario, array('url' => route('users.users_update',$usuario->id),
                        'method' => 'PUT', 'class'=>'m-form m-form--fit ajax-form')) }}
                    @component('forms/users', [
                        'usuario' => $usuario, 'perfis' => $perfis, 'unidades' => $unidades,
                        ]);
                    @endcomponent
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <a class="btn btn-primary btn-lg" href="{{route('users.users_index')}}">Cancelar</a>
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
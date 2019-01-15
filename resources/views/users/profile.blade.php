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
                <span class="m-nav__link-text">{{__('titles.view_profile')}}</span>
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
                            <h3 class="m-portlet__head-text">Cadastro de <span class="badge badge-primary">{{ $usuario->name }}</span> </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    {{ Form::model($usuario, array('url' => route('user.profile_update'),
                        'method' => 'PUT', 'class'=>'m-form m-form--fit')) }}
                    <div class="form-group row">
                        <div class="col-2 text-right">
                            <label for="nome">{{__('labels.name')}}</label>
                        </div>
                        <div class="col-6" title="Nome do Utilizador" data-toggle="tooltip">
                            <span class="form-control">{{ $usuario->name }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2 text-right">
                            <label for="email">{{__('labels.email')}}</label>
                        </div>
                        <div class="col-6" title="Endereço eletrônico de mensagens" data-toggle="tooltip">
                            <span class="form-control">{{ $usuario->email }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2 text-right">
                            <label for="password">{{__('labels.password')}}</label>
                        </div>
                        <div class="col-3" title="Senha de Acesso" data-toggle="tooltip">
                            <input type="password" class="form-control{{$errors->has('password') ? ' is-invalid' : ''}}"
                                   id="password" name="password" required="required"
                                   placeholder="Senha de Acesso" value="">
                        </div>
                        <div class="col-2 text-right">
                            <label for="repassword">{{__('labels.confirm_password')}}</label>
                        </div>
                        <div class="col-3" title="Redigite a Senha" data-toggle="tooltip">
                            <input type="password" class="form-control{{$errors->has('password_confirmation') ? ' is-invalid' : ''}}"
                                   id="repassword" name="password_confirmation" required="required"
                                   placeholder="Redigite a Senha">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2 text-right">
                            <label for="perfil">{{__('labels.profile')}}</label>
                        </div>
                        <div class="col-3" title="Perfil" data-toggle="tooltip">
                            <span class="form-control">{{ $usuario->profile }}</span>
                        </div>
                    </div>
                    @if(Auth::user()->profile == 'AGÊNCIA')
                    <div class="form-group row" id="agencia-block">
                        <div class="col-2 text-right">
                            <label for="agencia">{{__('labels.agencia')}}</label>
                        </div>
                        <div class="col-5" title="Agencia" data-toggle="tooltip">
                            <span class="form-control">{{ $usuario->agencia }}</span>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->profile == 'OPERADOR')
                    <div class="form-group" id="unidade-block">
                        <div class="col-2 text-right">
                            <label for="unidade">{{__('labels.unidade')}}</label>
                        </div>
                        <div class="col-5" title="Unidade" data-toggle="tooltip">
                            <span class="form-control">{{ $usuario->unidade }}</span>
                        </div>
                    </div>
                    @endif

                    <input type="hidden" name="_u" value="{{Auth::id()}}" />
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

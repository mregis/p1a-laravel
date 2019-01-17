@extends('layout')

@section('title',  'Capas de Lotes')
@section('content')

    <div class="row">
        <div class="col-12">
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
                                        <span class="m-nav__link-text">Capa de Lote</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Pesquisar</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <h3 class="m-portlet__head-text">
                                <i class="fas fa-search"></i>
                                Pesquisar Capa de Lote</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        {{ Form::open(array('url' => route('capalote.show'),
                                'method' => 'get',
                                'class'=>'m-form m-form--fit m-form--label-align-right')) }}
                        <div class="col-6">
                            <label for="capalote">Número Capa de Lote</label>
                            <input type="text" class="form-control form-control-lg" name="capalote"
                                   data-mask="9999999999999" required="required">
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-search"
                                       aria-hidden="true"></i>
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                        @csrf
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('dochistory')
    @endcomponent
@stop

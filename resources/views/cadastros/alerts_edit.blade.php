@extends('layout')

@section('title',  __('titles.alerts'))
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
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
                                        <h3 class="m-portlet__head-text">{{__('titles.edit_alert')}}</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{ Form::open(array('url' => route('alerts.api_edit_alert', $alert->id),
                    'method' => 'put',
                    'class'=>'m-form m-form--fit m-form--label-align-right ajax-form')) }}
                <div class="m-portlet m-portlet--tabs">
                    <div class="m-portlet__head m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x"
                            role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_1"
                                   role="tab">
                                <i class="la la-pencil-square"></i> Atualizar Ocorrência
                                    </a>
                            </li>
                        </ul>
                    </div>

                    <div class="m-portlet__body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group m-form__group row">
                            <div class="col-3">
                                <label for="product">Produto</label>
                                <span class="form-control form-control-lg">{{$alert->product->description}}</span>
                            </div>
                            <div class="col-3">
                                <label for="type">{{__('tables.type')}}</label>
                                <span class="form-control form-control-lg">{{$alert->type}}</span>
                            </div>
                            <div class="col-5">
                                <label for="content">{{__('labels.title')}}</label>
                                <span class="form-control form-control-lg">{{$alert->content}}</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-6">
                                <label for="description">{{__('titles.historic')}}</label>
                                        <textarea rows="4"
                                                  class="form-control form-control-lg m-input{{$errors->has('descricao') ? ' is-invalid' : ''}}"
                                                  name="description" id="description"
                                                  data-validation="notempty($(this))"
                                                  data-label="{{__('labels.description')}}"
                                                  data-error="{{__('labels.field_not_empty')}}"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="description">Anteriores</label>
                                    <textarea class="form-control form-control-lg"
                                              rows="4" readonly>{{$alert->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            {{ Form::submit(__('buttons.submit'), array('class' => 'btn btn-success btn-lg')) }}
                            <a class="btn btn-lg btn-outline-secondary" href="{{ route('cadastros.list_alert') }}">
                                {{__('buttons.cancel')}}</a>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_u" value="{{ Auth::id() }}"/>
                {{ csrf_field() }}
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop

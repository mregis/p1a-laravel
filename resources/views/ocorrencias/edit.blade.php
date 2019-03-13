@extends('layout')

@section('title',  'Atualizar Ocorrência')
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
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <h3 class="m-portlet__head-text">
                            <i class="la la-pencil-square"></i> Atualizar Ocorrência</h3>
                    </div>
                </div>

                {{ Form::open(array('url' => route('ocorrencias.edit', $ocorrencia->id),
                    'method' => 'put',
                    'class'=>'m-form m-form--fit m-form--label-align-right')) }}
                <div class="m-portlet m-portlet--tabs">
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
                                <span class="form-control form-control-lg">{{$ocorrencia->product->description}}</span>
                            </div>
                            <div class="col-3">
                                <label for="type">{{__('tables.type')}}</label>
                                <span class="form-control form-control-lg">{{$ocorrencia->type}}</span>
                            </div>
                            <div class="col-5">
                                <label for="content">{{__('labels.title')}}</label>
                                <span class="form-control form-control-lg">{{$ocorrencia->content}}</span>
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
                                              rows="4" readonly>{{$ocorrencia->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <button class="btn btn-success btn-lg" type="submit">
                                <i class="fas fa-save"></i> {{__('buttons.save')}}
                            </button>
                            <a class="btn btn-lg btn-outline-secondary" href="{{ route('ocorrencias.index') }}">
                                {{__('buttons.cancel')}}</a>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_u" value="{{ Auth::id() }}"/>
                <input type="hidden" name="_method" value="PUT"/>
                {{ csrf_field() }}
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop

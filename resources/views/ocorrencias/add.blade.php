@extends('layout')

@section('title',  'Adicionar Nova Ocorrência')
@section('content')
    <div class="row">
        <div class="col-sm">
            {{ Form::open([
                'url' => route('ocorrencias.new'),
                'class'=>'m-form m-form--fit m-form--label-align-right', '_method' => 'POST'
                ]) }}
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_u" value="{{Auth::id()}}">
            <div class="m-portlet">
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
                                    <a href="{{route('ocorrencias.index')}}" class="m-nav__link">
                                        <span class="m-nav__link-text">Ocorrências</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Nova Ocorrência</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <i class="far fa-plus-square"></i>
                                {{__('titles.add_alerts')}}
                            </h3>
                        </div>
                    </div>
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
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="product">Produto</label>
                            <select class="form-control form-control-lg m-input"
                                    name="product" id="product" required="required">
                                <option value="">{{__('labels.select')}}</option>
                                @foreach($products as $p)
                                    <option value="{{$p->id}}">{{$p->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="type">{{__('tables.type')}}</label>
                            <select class="form-control form-control-lg m-input"
                                    name="type" id="type" required="required">
                                <option value="">{{__('labels.select')}}</option>
                                @foreach($ocorrencia_types as $t)
                                    <option value="{{$t}}">{{$t}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="content">{{__('labels.title')}}</label>
                            <input class="form-control form-control-lg m-input"
                                   name="content" id="content" required="required"/>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="description">Histórico</label>
                            <textarea rows="4" class="form-control m-input" name="description" id="description"
                                      placeholder="Histórico da ocorrência"></textarea>
                        </div>
                    </div>
                </div>

                {{ csrf_field() }}

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="far fa-save"></i> Cadastrar
                        </button>
                        <a class="btn btn-lg btn-outline-secondary" href="{{route('ocorrencias.index')}}">
                            {{__('buttons.cancel')}}</a>
                    </div>
                </div>

            </div>
            {{ Form::close() }}
        </div>
    </div>

@stop


@extends('layout')

@section('title',  __('titles.profiles'))
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tabs">
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
                                        <span class="m-nav__link-text">{{__('titles.profiles')}}</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">{{__('titles.add_profile')}}</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x"
                                role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1"
                                       role="tab">
                                        <?php if(isset($profile)):?>
                                        <i class="la la-pencil-square"></i> Atualizar
                                        <?php else: ?>
                                        <i class="la la-plus-circle"></i> Adicionar
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2"
                                       role="tab">
                                        <i class="la la-eye"></i>
                                        Listagem de Perfis
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                <div class="col-md-12">
                                    <div class="m-portlet m-portlet--tab">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon m--hide">
                                                        <i class="la la-gear"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text">
                                                        @if (isset($profile))
                                                            {{__('titles.edit_profile')}}
                                                        @else
                                                            {{__('titles.add_profile')}}
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::open(array('url' => url('api/profiles'),
                                            'class'=>'m-form m-form--fit m-form--label-align-right ajax-form')) }}
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-4">
                                                    <label for="type">Nome</label>
                                                    <input type="text" class="form-control form-control-lg m-input{{$errors->has('nome') ? ' is-invalid' : ''}}"
                                                           name="nome" id="nome"
                                                           data-validation="notempty($(this))"
                                                           data-label="{{__('labels.name')}}"
                                                           data-error="{{__('labels.field_not_empty')}}"
                                                           placeholder="Nome do Produto"
                                                           value="@if(isset($profile) && $profile->nome) {{$profile->nome}} @endif">
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="form-group m-form__group row">
                                                <div class="col-6">
                                                    <label for="descricao">{{__('labels.description')}}</label>
                                                    <textarea rows="2" class="form-control form-control-lg m-input{{$errors->has('descricao') ? ' is-invalid' : ''}}"
                                                              name="descricao" id="descricao"
                                                              data-validation="notempty($(this))"
                                                              data-label="{{__('labels.bank_name')}}"
                                                              data-error="{{__('labels.field_not_empty')}}"
                                                              placeholder="{{__('labels.description')}}"
                                                            >@if(isset($profile) && $profile->descricao){{$profile->descricao}}@endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                            <div class="m-form__actions">
                                                {{ Form::submit(__('buttons.submit'), array('class' => 'btn btn-success btn-lg')) }}
                                                <button type="reset" class="btn btn-lg btn-outline-secondary"
                                                        onclick="window.history.back()">{{__('buttons.cancel')}}</button>
                                            </div>
                                        </div>
                                        {{ csrf_field() }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                <table class="table table-bordered m-table
                                    m-table--head-bg-brand text-center table-striped
                                    table-responsive compact">
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">PERFIL</th>
                                        <th scope="col">DESCRIÇÃO</th>
                                        <th scope="col">AÇÕES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profiles as $i => $p)
                                            <tr class="{{ ( $i % 2 == 0 ? 'even' : 'odd')}}">
                                                <td scope="row">{{$p->id}}</td>
                                                <td scope="row">{{$p->nome}}</td>
                                                <td scope="row">{{$p->descricao}}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('cadastros.edit_profile', $p->id) }}"
                                                       data-toggle="tooltip"
                                                       title="{{__('buttons.edit')}}"
                                                       class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="{{ route('cadastros.delete_profile', $p->id) }}" data-toggle="tooltip"
                                                       title="{{__('buttons.delete')}}"
                                                       onclick="if(confirm('Deseja remover esse registro ?')){return true;}else{return false;}"
                                                       class="btn btn-danger btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

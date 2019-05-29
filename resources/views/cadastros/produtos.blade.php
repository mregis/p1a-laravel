@extends('layout')

@section('title',  __('titles.product'))
@section('content')

    <div class="row">
        <div class="col-12">
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
                                        <h3 class="m-portlet__head-text">{{__('titles.product')}}</h3>
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
                                        <?php if(isset($produto)):?>
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
                                        Listagem de Produtos
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
                                        {{ Form::open(array('url' => url('api/products'),
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
                                                    <input type="text" class="form-control form-control-lg m-input{{$errors->has('type') ? ' is-invalid' : ''}}"
                                                           name="type" id="type"
                                                           data-validation="notempty($(this))"
                                                           data-label="{{__('labels.type')}}"
                                                           data-error="{{__('labels.field_not_empty')}}"
                                                           placeholder="Nome do Produto"
                                                           value="@if(isset($produto) && $produto->type) {{$produto->type}} @endif">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="mod">Tipo</label>
                                                    <select class="form-control form-control-lg m-input m-input--square{{$errors->has('mod') ? ' is-invalid' : ''}}"
                                                            name="mod" id="mod"
                                                            data-validation="notempty($(this))">
                                                        <option>{{__('labels.select')}}</option>
                                                        <option value="documento"
                                                                @if(isset($produto) && $produto->mod == 'documento') selected
                                                                @endif;>Documento
                                                        </option>
                                                        <option value="produto"
                                                                @if(isset($produto) && $produto->mod == 'produto') selected
                                                                @endif;>Produto
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="form-group m-form__group row">
                                                <div class="col-6">
                                                    <label for="description">{{__('labels.description')}}</label>
                                                    <textarea rows="2" class="form-control form-control-lg m-input{{$errors->has('description') ? ' is-invalid' : ''}}"
                                                              name="description" id="description"
                                                              data-validation="notempty($(this))"
                                                              data-label="{{__('labels.bank_name')}}"
                                                              data-error="{{__('labels.field_not_empty')}}"
                                                              placeholder="{{__('labels.description')}}"
                                                            >@if(isset($produto) && $produto->description){{$produto->description}}@endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                            <div class="m-form__actions">
                                                <a class="btn btn-lg btn-outline-secondary"
                                                   href="{{route('cadastro.produtos')}}">{{__('buttons.cancel')}}</a>
                                                {{ Form::submit(__('buttons.submit'), array('class' => 'btn btn-success btn-lg')) }}

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
                                        <th scope="col">PRODUTO</th>
                                        <th scope="col">DESCRIÇÃO</th>
                                        <th scope="col">TIPO</th>
                                        <th scope="col">AÇÕES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produtos as $i => $p)
                                        <tr class="{{ ( $i % 2 == 0 ? 'even' : 'odd')}}">
                                            <td scope="row">{{$p->id}}</td>
                                            <td scope="row">{{$p->type}}</td>
                                            <td scope="row">{{$p->description}}</td>
                                            <td scope="row">{{$p->mod}}</td>
                                            <td class="text-center">
                                                <a href="{{ route('cadastros.edit_produto', $p->id) }}"
                                                   data-toggle="tooltip"
                                                   title="{{__('buttons.edit')}}"
                                                   class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a href="{{ route('cadastros.delete_produto', $p->id) }}" data-toggle="tooltip"
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

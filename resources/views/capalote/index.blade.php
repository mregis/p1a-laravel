@extends('layout')

@section('title',  __('Contingência'))

@section('content')

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="/dashboard" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a href="javascript:void(0)" class="m-nav__link">
                <span class="m-nav__link-text">Capa Lote</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a href="javascript:void(0)" class="m-nav__link">
                <span class="m-nav__link-text">{{__('Contingência')}}</span>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon"><i class="la la-new"></i></span>
                        <h3 class="m-portlet__head-text">Capa de Lote</h3>
                    </div>
                </div>
            </div>

            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                                    <i class="la la-plus-circle"></i> Adicionar
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                                    Disponíveis para impressão
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
                                                    <i class="la la-plus-circle"></i>
                                                </span>
                                                <h3 class="m-portlet__head-text">
                                                    {{__('titles.add_capalote')}}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::open(array('url' => route('capalote.new'))) }}
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
                                            <div class="col-4">
                                                <label for="tipo_documento">Tipo de Documento</label>
                                                <select class="form-control form-control-lg m-input m-input--square{{$errors->has('tipo_documento') ? ' is-invalid' : ''}}"
                                                        name="tipo_documento" id="tipo_documento" required="required">
                                                    <option disabled selected>{{__('labels.select')}}</option>
                                                    @foreach($doc_types as $i => $t)
                                                        <option value="{{$i}}"{{old('tipo_documento') == $i ? ' selected="selected"' : ''}}>{{$t}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <div class="col-3">
                                                <label for="origem">{{__('labels.origem')}}:</label>
                                                <input type="text" class="form-control form-control-lg m-input{{$errors->has('origem') ? ' is-invalid' : ''}}"
                                                       name="origem" id="origem" data-mask="0000" required="required"
                                                       data-label="{{__('labels.origem')}}"
                                                       placeholder="{{__('labels.origem')}}"
                                                       @if(Auth::user()->profile == 'AGÊNCIA')
                                                       value="{{Auth::user()->juncao}}" readonly="readonly"
                                                       @else
                                                       value="{{old('origem')}}"
                                                        @endif
                                                        >
                                            </div>

                                            <div class="col-3">
                                                <label for="destino">{{__('labels.destino')}}:</label>
                                                <input type="text" class="form-control form-control-lg m-input{{$errors->has('destino') ? ' is-invalid' : ''}}" name="destino" id="destino"
                                                       data-mask="0000" required="required"
                                                       data-validation="notempty($(this))" data-label="{{__('labels.destino')}}"
                                                       data-error="{{__('labels.field_not_empty')}}" placeholder="Agência Destino"
                                                       value="{{old('destino')}}">
                                            </div>

                                            <div class="col-3">
                                                <label for="qtdedocs">{{__('labels.qtdedocs')}}:</label>
                                                <input type="text" class="form-control form-control-lg m-input{{$errors->has('qtdedocs') ? ' is-invalid' : ''}}" name="qtdedocs"
                                                       id="qtdedocs" data-mask="00" required="required"
                                                       data-label="{{__('labels.qtdedocs')}}" placeholder="Qtde Documentos"
                                                       value="{{old('qtdedocs')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            {{ Form::submit(__('GERAR CAPA'), array('class' => 'btn btn-success btn-lg')) }}
                                        </div>
                                    </div>
                                    @csrf
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                            {{ Form::open(array('url' => route('capalote.imprimir-multiplo'),
                            'target' => '_blank', 'id' => 'formprint-capalote')) }}
                            <div class="table-responsive-xl">
                                <input type="hidden" id="columns"
                                       value="action,content,from_agency,to_agency,created_at,status,print">

                                <input type="hidden" id="baseurl"
                                           value="{{ route('capalote.api-index', Auth::user()->id) }}">
                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                       id="datatable" data-column-defs='[{"targets":[0,6],"orderable":false}]'
                                       data-order='[[ 4, "desc" ]]'>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>{{__('Capa Lote')}}</th>
                                            <th>{{__('Origem')}}</th>
                                            <th>{{__('Destino')}}</th>
                                            <th>{{__('Movimento')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('tables.action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-print" aria-hidden="true"></i> {{__('IMPRIMIR CAPA DE LOTE')}}
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
    </div>

@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $("#tipo_documento").change(function() {
                if ([{{implode(',', $automatic_types)}}]
                                .indexOf(parseInt($('#tipo_documento option:selected').val())) > -1) {
                    $('#destino').val('4510').attr('readonly', true);
                } else {
                    $('#destino').attr('readonly', false);
                }
            });
            $(".is-invalid").change(function(){$(this).removeClass('is-invalid');});
            $('#formprint-capalote').on('submit', function() {
                if ($('[name="capalote[]"]:checked').length < 1) {
                    alert('É necessário marcar ao menos 1 capa de lote para impressão.');
                    return false;
                };
            });
        });
        // Impressão de Capa de Lote
        function view(docid) {
            $('[name="capalote[]"]').attr('checked', false);
            $('#capalote-' + docid).attr('checked', true);
            $('#formprint-capalote').submit();
        };
    </script>
@stop
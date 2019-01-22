@extends('layout')

@section('title',  __('Contingência'))

@section('content')
    <div class="row" id="capalote">
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
                                        <span class="m-nav__link-text">Capa de Lote</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Exibir</h3>
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
                                Capa de Lote <span class="badge badge-pill badge-primary">{{$doc->content}}</span>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label>Movimento</label>
                                <span class="form-control form-input-lg">
                                        {{(new \Carbon\Carbon($doc->file->movimento))->format('d/m/Y')}}
                                </span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Junção Origem</label>
                                <span class="form-control form-input-lg">{{$doc->origin}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Junção Destino</label>
                                <span class="form-control form-input-lg">{{$doc->destin}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Histórico</label>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-responsive table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>REGISTRO</th>
                                                <th>DATA</th>
                                                <th>USUÁRIO</th>
                                                <th>PERFIL</th>
                                                <th>LOCAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($doc->history as $h)
                                            <tr>
                                                <td>{{__('status.' . $h->description)}}</td>
                                                <td>{{(new \Carbon\Carbon($h->created_at))->format('d/m/Y H:i')}}</td>
                                                <td>{{$h->user}}</td>
                                                <td>{{$h->user->profile}}</td>
                                                <td>{{$h->user->getLocal()}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col">
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <a href="{{route('capalote.buscar')}}" class="btn btn-lg btn-outline-secondary">
                                    <i class="fas fa-search-plus"></i> Nova Busca</a>
                                <button class="btn btn-success btn-lg" onclick="printBy('#capalote')">
                                    <i class="fas fa-print"></i> Imprimir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        function printBy(selector) {
            var $print = $(selector).clone().addClass('print').prependTo('body');
            $('.m-page').hide();
            window.print();
            $print.remove();
            $('.m-page').show();
        }
    </script>
@stop
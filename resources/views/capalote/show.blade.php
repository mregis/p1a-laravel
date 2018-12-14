@extends('layout')

@section('title',  __('Contingência'))

@section('styles')
    <style type="text/css">

        .forma-head, .forma-body, .forma-footer {
            width: 197mm;
            border: 1px solid #333333;
            font-weight: bold;
            color: #000000;
        }
        .forma-head {
            height: 10mm;
            border-bottom:dashed thin #000000;
        }
        .forma-body {
            height: 55mm;
            border-top:none;
            border-bottom:none;
            padding: 2mm 2mm 1mm;
        }
        .forma-footer {
            height: 15mm;
            border-top: dashed thin #000000;
        }
        .forma-body div {

        }
        .forma-footer {
            padding: 1.5em 0 0 1em;
        }
        .brand {
            font-size: 18pt;
            padding-left: 4mm;
        }
        .sub-brand {
            font-size: 12pt;
            margin-left: 2em;
        }
        .cd { font-size: 14pt; }
        .agencia { font-size: 15pt; }
        #capalote label {
            font-size: 12pt;
            font-weight: normal;
        }
    </style>
@stop

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
                <span class="m-nav__link-text">{{__('Imprimir')}}</span>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tabs">

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon"><i class="la la-print"></i></span>
                            <h3 class="m-portlet__head-text">Impressão de Capa de Lote</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-portlet__body-caption">
                        <div class="m-portlet__body-title">
                            <h5 class="m-portlet__body-text">Imprimir capa de lote para substituição mediante extravio ou inutilização</h5>
                        </div>
                    </div>

                    <div class="container" id="capalote">
                        <div class="forma-head">
                            <div class="brand">237 - Bradesco <span class="sub-brand">DOCUMENTOS DEVOLVIDOS PARA OUTRAS UNIDADES</span></div>
                        </div>
                        <div class="forma-body">
                            <div class="cd text-center">CENTRO DE DISTRIBUIÇÃO - {{$doc->destino->cd}}</div>
                            <div class="agencia">
                                <label>Destino:</label> {{$doc->to_agency}}: {{ $doc->destino->nome }} - {{ $doc->destino->cidade }}/{{ $doc->destino->uf }} </div>
                            <div class="capalote"><label>N<sup>o</sup> Lote p/Baixa:</label>
                                <span class="ml-5">
                                    <svg id="barcode" jsbarcode-format="code128" jsbarcode-value="{{$doc->content}}"
                                     jsbarcode-textmargin="0" jsbarcode-fontoptions="bold"
                                     jsbarcode-height="38" jsbarcode-width="3"></svg>
                                    </span>
                            </div>
                            <div class="text"><label>Quantidade de Documentos: </label> {{ $doc->qt_item }}
                                <span class="ml-5">Data: {{ \Carbon\Carbon::parse($doc->updated_at)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="forma-footer">
                            <div><label>Origem: </label> {{ $doc->from_agency }}: {{ $doc->origem->nome }}</div>
                        </div>
                    </div>

                    <div class="container">
                        <button class="btn btn-lg btn-success" onclick="printBy('#capalote');"><i class="fas fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                </div>


            </div>
        </div>
    </div>


@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            JsBarcode("#barcode").init();
        });
        function printBy(selector) {
            var $print = $(selector).clone().addClass('print').prependTo('body');
            $('.m-page').hide();
            window.print();
            $print.remove();
            $('.m-page').show();
        }
    </script>
@stop
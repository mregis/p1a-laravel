<link href="https://fonts.googleapis.com/css?family=Libre+Barcode+39+Extended+Text" rel="stylesheet">
<style type="text/css">
    body {
        font-family: "Raleway", sans-serif, "Open Sans", -apple-system, BlinkMacSystemFont,
        "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji",
        "Segoe UI Emoji", "Segoe UI Symbol";
    }

    .text-center {
        text-align: center;
    }

    .forma-head, .forma-body, .forma-footer {
        width: 190mm;
        border: 1px solid #333333;
        font-weight: bold;
        color: #000000;
        padding: 2mm 2mm 1mm;
    }

    .forma-head {
        height: 10mm;
        border-bottom: dashed thin #333333;
        margin-top: 1em;
    }

    .forma-body {
        height: 55mm;
        border-top: none;
        border-bottom: none;
    }

    .forma-footer {
        height: 15mm;
        border-top: dashed thin #333333;
    }

    .forma-footer {
        margin-bottom: 1em;
    }

    .brand {
        font-size: 18pt;
        padding-left: 4mm;
    }

    .g-content {
        font-size: 14pt;
    }

    .sub-brand {
        font-size: 12pt;
        margin-left: 2em;
    }

    .cd {
        font-size: 14pt;
    }

    #capalote label {
        font-size: 12pt;
        font-weight: bold;
        text-align: right;
        width: 120pt;
        display: inline-block;
        color: #555555;
    }

    .barcode {
        font-family: 'Libre Barcode 39 Extended Text', cursive;
        font-size: 48pt;
        display: inline-block;
        margin-left: 50pt !important;
        font-weight: normal;
    }

    .group {
        padding: 2.5mm 0 2.5mm 0;
    }
    .g-block {
        height: 100mm;
        border-bottom: dashed thin #666666;
    }
    .page-break {
        page-break-after: always;
    }

</style>

<h3 class="text-center">Impressão de Capa de Lote</h3>


<h5 class="text-center">Imprimir capa de lote para substituição mediante extravio ou inutilização</h5>
<div class="container">
    <div class="container" id="capalote">
        @foreach($docs as $i => $doc)
            <div class="g-block{{  ($i % 2 != 0 ? ' page-break' : '') }}">
                <div class="forma-head">
                    <div class="brand">237 - Bradesco <span
                                class="sub-brand">DOCUMENTOS DEVOLVIDOS PARA OUTRAS UNIDADES</span></div>
                </div>
                <div class="forma-body">
                    <div class="cd text-center">CENTRO DE DISTRIBUIÇÃO - {{$doc->destino->cd}}</div>
                    <div class="group">
                        <label>Destino:</label>
                        <span class="g-content">
                            {{$doc->to_agency}}: {{ $doc->destino->nome }} - {{ $doc->destino->cidade }}/{{ $doc->destino->uf }}
                        </span>
                    </div>
                    <div class="group">
                        <label>N<sup>o</sup> Lote p/Baixa:</label>

                        <div class="barcode">{{$doc->content}}</div>
                    </div>
                    <div class="group">
                        <label>Qtde Documentos: </label> <span class="g-content">{{ $doc->qt_item }}</span>
                        <label>Data: </label>
                        <span class="g-content"> {{ \Carbon\Carbon::parse($doc->updated_at)->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="forma-footer">
                    <div class="group">
                        <label>Origem: </label>
                        <span class="g-content">{{ $doc->from_agency }}: {{ $doc->origem->nome }}</span>
                    </div>
                </div>

            </div>

        @endforeach
    </div>
</div>


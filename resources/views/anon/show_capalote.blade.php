<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 07/01/2019
 * Time: 21:55
 */
?>
        <!DOCTYPE html>

<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        {{__('titles.show_capalote', ['capalote' => $doc->content])}}
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/appfill.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/appmain.css')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{asset('assets/demo/default/media/img/logo/favicon.ico')}}" />
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"
      style="background: url('{{ asset('assets/app/media/img/bg/bg-1.png') }}') 0 0 #a3c3e9;">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="card">
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 justify-content-md-center">
                        <img src="{{asset('assets/app/media/img/logos/logo-auth.jpg')}}" class="card-img">
                    </div>
                </div>

                <div class="card-header"><h3>Histórico Capa de Lote
                        <span class="bagde badge-primary badge-pill">{{$doc->content}}</span></h3></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover nowrap auto-dt" id="history"
                                data-dom="B" data-ordering="false"
                               data-column-defs='[{ "targets": [0,1,2,3,4], "visible": false} ]'>
                            <thead class="table-dark">
                            <tr>
                                <th>CAPA LOTE</th>
                                <th>JUNÇÃO ORIGEM</th>
                                <th>JUNÇÃO DESTINO</th>
                                <th>DATA MOVIMENTO</th>
                                <th>DATA ENVIO</th>
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
                                    <td>{{$h->doc->content}}</td>
                                    <td>{{$h->doc->origin}}</td>
                                    <td>{{$h->doc->destin}}</td>
                                    <td>{{\Carbon\Carbon::parse($h->doc->file->movimento)->format('d/m/Y')}}</td>
                                    <td>{{\Carbon\Carbon::parse($h->doc->file->created_at)->format('d/m/Y H:i')}}</td>
                                    <td>{{$h->description}}</td>
                                    <td>{{\Carbon\Carbon::parse($h->created_at)->format('d/m/Y H:i')}}</td>
                                    <td>{{$h->user->name}}</td>
                                    <td>{{$h->user->profile}}</td>
                                    <td>{{ ($h->user->agencia ? $h->user->agencia->name : $h->user->unidade) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col m--align-left">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-home"></i> Autenticar-se</a>
                        </div>
                        <div class="col m--align-right">
                            <a href="{{ route('anon.check_capalote') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-search"></i> Nova Pesquisa</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span class="text-muted">Address S.A - 2019 - Todos os direitos reservados</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Only to avoid Vue #app not found error -->
    <div id="app"></div>
</body>
<!--begin::Base Scripts -->
<script src="{{ mix('/js/polyfill.min.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/manifest.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/vendor.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/noCommonJS.libs.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/custom.scripts.js') }}" type="text/javascript"></script>
<!--end::Base Scripts -->
@component('flashmessages')
@endcomponent
</html>

<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 07/01/2019
 * Time: 21:55
 */
?>
        <!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>
        {{__('titles.show_capalote', ['capalote' => $doc->content])}}
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/appfill.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/appmain.css')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{asset('assets/demo/default/media/img/logo/favicon.ico')}}"/>
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"
      style="background: url('{{ asset('assets/app/media/img/bg/bg-1.png') }}') 0 0 #a3c3e9;">
<div class="container-fluid">
    <div class="row justify-content-md-center" id="capalote">
        <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <img src="{{asset('assets/app/media/img/logos/logo-auth.jpg')}}" class="card-img-top col-md-4">

                <h3 class="m-portlet__head-text">
                    Capa de Lote <span class="badge badge-pill badge-primary">{{$doc->content}}</span>
                </h3></div>
            <div class="card-body">
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
                                        <td>{{$h->description}}</td>
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
                <div class="form-group">
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <a href="{{route('anon.check_capalote')}}" class="btn btn-lg btn-outline-secondary">
                            <i class="fas fa-search"></i> Nova Pesquisa</a>
                        <a href="{{route('login')}}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Voltar ao Login
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <span class="text-muted">Address S.A - 2019 - Todos os direitos reservados</span>
            </div>
        </div></div>
    </div>
</div>
<!-- Only to avoid Vue #app not found error -->
<div id="app"></div>

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
</body>
</html>

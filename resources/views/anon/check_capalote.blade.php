<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 07/01/2019
 * Time: 21:55
 */
?>
        <!DOCTYPE html>

<html lang="pt" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>{{__('titles.check_capalote')}}</title>
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
    <!-- Only to avoid Vue #app not found error -->
    <div id="app"></div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="card">
                <img src="{{asset('assets/app/media/img/logos/logo-auth.jpg')}}" class="card-img-top">
                <div class="card-header"><h3>Rastrear Capa de Lote</h3></div>
                <div class="card-body">
                    <form method="post" action="{{ route('anon.show_capalote') }}">
                        <p class="">Entre com o número da Capa de Lote a ser pesquisada</p>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" name="capalote" autocomplete="off" />
                        </div>
                        <div class="form-group row">
                            <div class="col m--align-left">
                                <a href="{{ route('login') }}" class="btn btn-lg btn-primary"><i class="fas fa-home"></i> Voltar ao Login</a>
                            </div>
                            <div class="col m--align-right">
                                <button class="btn btn-lg btn-primary" type="submit"><i class="fas fa-search"></i> Pesquisar</button>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
                <div class="card-footer">
                    <span class="text-muted">Address S.A - 2019 - Todos os direitos reservados</span>
                </div>
            </div>
        </div>
    </div>

</body>

<!--begin::Base Scripts -->
<script src="{{ mix('/js/polyfill.min.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/manifest.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/vendor.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/noCommonJS.libs.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/custom.scripts.js') }}" type="text/javascript"></script>
<!--end::Base Scripts -->

<!-- Flash Messages if exists -->
@component('flashmessages')
@endcomponent
</html>

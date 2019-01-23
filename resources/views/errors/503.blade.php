<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 23/01/2019
 * Time: 13:22
 */
?>
        <!DOCTYPE html>

<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>Em Manutenção</title>
    <meta name="description" content="Sistema de Controle e Rastreamento de Cheques em Trânsito">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/appfill.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/appmain.css')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{asset('assets/demo/default/media/img/logo/favicon.ico')}}" />
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"
      style="background: url('{{ asset('assets/app/media/img/bg/bg-1.png') }}') 0 0 #a3c3e9;">
<!-- begin:: Page -->

    <div class="row justify-content-md-center">
        <div class="card">
            <div class="m-login__container">
                <img src="{{asset('images/logo.png')}}" class="card-img-top">

                <div class="m-login__head card-header">
                    <h3 class="m-login__title">O Sistema se encontra em Manutenção</h3>
                    <p>Volte em alguns minutos</p>
                </div>
                <div class="card-body">
                    <div class="m-login__signin">
                        <div class="card-body">
                            <img src="{{asset('images/manutencao.jpg')}}" class="card-img-bottom">
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

<!-- end:: Page -->
<!--begin::Base Scripts -->
<script src="{{ mix('/js/polyfill.min.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/manifest.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/vendor.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/noCommonJS.libs.js') }}" type="text/javascript"></script>
<script src="{{ mix('/js/custom.scripts.js') }}" type="text/javascript"></script>
<!--end::Base Scripts -->


</body>

</html>



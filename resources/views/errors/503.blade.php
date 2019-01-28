<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 23/01/2019
 * Time: 13:22
 */
?>

        <!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>Em Manutenção</title>
    <meta name="description" content="Sistema de Controle e Rastreamento de Cheques em Trânsito">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/appfill.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/appmain.css')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{asset('assets/demo/default/media/img/logo/favicon.ico')}}"/>
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"
      style="background: url('{{ asset('assets/app/media/img/bg/bg-1.png') }}') 0 0 #a3c3e9;">
<!-- begin:: Page -->

<div class="container-fluid">
    <div class="row justify-content-md-center maintenance">
        <div class="card">
            <div class="card-header text-center">
                <h3><span class="text-warning">
                        <i class="fas fa-wrench"></i>
                    </span> Sistema em Manutenção</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ asset('/images/manutencao_md.png') }}" class="card-img-top w-75"/>
                </div>
                <h4>O sistema está sendo atualizado.</h4>
                <h5>Volte em alguns instantes para aproveitar os novos recursos que estamos preparando.</h5>

                <p class="text-muted">Pedimos desculpas por qualquer incoveniente e esperamos contar com sua
                    compreensão</p>

            </div>
            <div class="card-footer">
                <span class="text-muted">Address S.A - 2019 - Todos os direitos reservados</span>
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



<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 23/01/2019
 * Time: 13:22
 */
?>
        <!DOCTYPE html>
<html lang="pt-br">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>Recurso não encontrado</title>
    <meta name="description" content="Sistema de Controle e Rastreamento de Cheques em Trânsito">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ mix('css/appfill.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/appmain.css')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{asset('assets/demo/default/media/img/logo/favicon.ico')}}"/>
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"
      style="background: url('{{ asset('assets/app/media/img/bg/bg-1.png') }}') 0 0 #a3c3e9;">
<!-- begin:: Page -->

<div class="container">
    <div class="row justify-content-md-center">
        <div class="card mt-3 text-center">
            <div class="pt-5">
                <img src="{{ asset('/images/novo_lugar_vazio.jpg') }}" class="card-img"/>

                <div class="card-img-overlay">

                    <div class="card-header text-warning">
                        <h2><i class="fas fa-street-view fa-2x"></i> Se perdeu?</h2>

                    </div>
                    <div class="card-body h-75">
                        <div class="mt-3 mb-3 text-dark">
                            <h3>Parece que você encontrou um lugar novo</h3>

                            <p></p>

                            <h3>Infelizmente não há nada aqui para ser exibido.</h3>

                            <p></p>

                            <p class="">Você pode voltar a sua página inicial
                                <a href="{{route('home')}}"> clicando aqui</a></p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="text-muted">Address S.A - 2019 - Todos os direitos reservados</span>
                    </div>
                </div>
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

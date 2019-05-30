<!DOCTYPE html>

<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        {{config('view.TITLE_AUTH')}}
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/appmain.css')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{asset('assets/demo/default/media/img/logo/favicon.ico')}}" />
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"
      style="background: url('{{ asset('assets/app/media/img/bg/bg-1.png') }}') 0 0 #a3c3e9;">
<!-- begin:: Page -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1 container"
         id="m_login">
        <div class="row justify-content-md-center">
            <div class="card">
                <div class="m-login__container">
                    <img src="{{asset('assets/app/media/img/logos/logo-auth.jpg')}}" class="card-img-top">

                    <div class="m-login__head card-header">
                        <h3 class="m-login__title">Rastreamento de cheques em trânsito</h3>
                    </div>
                    <div class="card-body">
                        <div class="m-login__signin">
                            <div class="card-body">
                                <form class="m-login__form m-form" action="{{url('auth/login')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input class="form-control m-input form-control-lg" type="text"
                                               data-toggle="tooltip"
                                               title="Informe seu e-mail na forma 9999.adm ou 9999.adm@bradesco.com.br"
                                               placeholder="Informe seu E-mail" name="username" autocomplete="off"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control form-control-lg m-input m-login__form-input--last"
                                               type="password" placeholder="Informe sua senha" name="password"
                                                required>
                                    </div>
                                    <div class="m-login__form-action">
                                        <button id="m_login_signin_submit"
                                                class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                            Login
                                        </button>
                                    </div>

                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-right m-login__form-right">
                                            <a href="javascript:;" id="m_login_forget_password">
                                                {{ __('labels.forgot_password') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-right m-login__form-right">
                                            <a href="{{ route('anon.check_capalote') }}" id="m_login_check_capalote">
                                                {{ __('labels.check_capalote') }}
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="m-login__forget-password">
                            <div class="m-login__head">
                                <h3 class="m-login__title">Esqueceu a Senha?</h3>
                                <div class="m-login__desc text-muted">
                                    Preencha os campos abaixo para recuperar sua senha
                                </div>
                            </div>
                            <form class="m-login__form m-form" action="">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input form-control-lg" type="text"
                                           placeholder="Preencha seu email" name="email" id="m_email"
                                           autocomplete="off" required/>
                                </div>
                                <div class="m-login__form-action">
                                    <button id="m_login_forget_password_submit"
                                            class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                        Enviar
                                    </button>
                                    &nbsp;&nbsp;
                                    <button id="m_login_forget_password_cancel"
                                            class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="m-login__account"></div>
                    </div>
                    <div class="card-footer">
                        <span class="text-muted">Address S.A - 2019 - Todos os direitos reservados</span>
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
{{--<script src="{{ mix('/js/noCommonJS.libs.js') }}" type="text/javascript"></script> --}}
<script src="{{ mix('/js/custom.scripts.js') }}" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Snippets -->
<script src="{{mix('/js/login.js')}}" type="text/javascript"></script>
<!--end::Page Snippets -->

</body>

</html>


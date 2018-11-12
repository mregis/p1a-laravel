<!DOCTYPE html>

<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        <?php echo e(config('view.TITLE_AUTH')); ?>

    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="<?php echo e(asset('assets/vendors/base/vendors.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/demo/default/base/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/demo/default/media/img/logo/favicon.ico')); ?>" />
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background: url(../../../assets/app/media/img/bg/bg-1.png) 0 0 #a3c3e9;">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container" style="background-color:#fff;padding:40px 20px 20px 20px;">
                <div class="m-login__logo">
                    <a href="#">
                        <img src="<?php echo e(asset('assets/app/media/img/logos/logo-auth.jpg')); ?>" style="width:100%">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Preencha os dados abaixo
                        </h3>
                    </div>
                    <form class="m-login__form m-form" action="<?php echo e(url('auth/login')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group m-form__group">
                            <input class="form-control m-input"    type="text" placeholder="Preencha seu email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Preencha sua senha" name="password">
                        </div>
                        <div class="row m-login__form-sub">

                            <div class="col m--align-right m-login__form-right">
                                <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                    esqueci senha
                                </a>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="m-login__signup">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Sign Up
                        </h3>
                        <div class="m-login__desc">
                            Enter your details to create your account:
                        </div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="password" placeholder="Password" name="password">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
                        </div>
                        <div class="row form-group m-form__group m-login__form-sub">
                            <div class="col m--align-left">
                                <label class="m-checkbox m-checkbox--light">
                                    <input type="checkbox" name="agree">
                                    I Agree the
                                    <a href="#" class="m-link m-link--focus">
                                        terms and conditions
                                    </a>
                                    .
                                    <span></span>
                                </label>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signup_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Sign Up
                            </button>
                            &nbsp;&nbsp;
                            <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
                <div class="m-login__forget-password">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Esqueceu sua senha ?
                        </h3>
                        <div class="m-login__desc">
                            Preencha os campos abaixo para recuperar sua senha
                        </div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Preencha seu email" name="email" id="m_email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Enviar
                            </button>
                            &nbsp;&nbsp;
                            <button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="m-login__account">

                    

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<!--begin::Base Scripts -->
<script src="<?php echo e(asset('assets/vendors/base/vendors.bundle.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/demo/default/base/scripts.bundle.js')); ?>" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Snippets -->
<script src="<?php echo e(asset('assets/snippets/pages/user/login.js')); ?>" type="text/javascript"></script>
<!--end::Page Snippets -->
</body>

</html>


<!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>
        Address - @yield('title').
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('assets/demo/default/media/img/logo/favicon.ico')}}"/>
    <link href="{{ mix('css/appfill.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/appmain.css')}}" rel="stylesheet" type="text/css">
    <!--end::Base Styles -->

    @yield('styles')

</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed
    m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark
    m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <!-- BEGIN: Header -->
        <header class="m-grid__item m-header" data-minimize-offset="200" data-minimize-mobile-offset="200">
            <div class="m-container m-container--fluid m-container--full-height">
                <div class="m-stack m-stack--ver m-stack--desktop">
                    <!-- BEGIN: Brand -->
                    <div class="m-stack__item m-brand  m-brand--skin-dark ">
                        <div class="m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                <a href="/dashboard" class="m-brand__logo-wrapper">
                                    <img alt="" src="{{url('assets/demo/default/media/img/logo/logo_default_dark.png')}}"/>
                                </a>
                            </div>
                            <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                <!-- BEGIN: Left Aside Minimize Toggle -->
                                <a href="javascript:;" id="m_aside_left_minimize_toggle"
                                   class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                                    <span></span>
                                </a>
                                <!-- END -->
                                <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                                   class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                    <span></span>
                                </a>
                                <!-- END -->
                                <!-- BEGIN: Topbar Toggler -->
                            </div>
                        </div>
                    </div>
                    <!-- END: Brand -->
                    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                        <!-- BEGIN: Horizontal Menu -->
                        <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark "
                                id="m_aside_header_menu_mobile_close_btn">
                            <i class="la la-close"></i>
                        </button>
                        <div id="m_header_menu"
                             class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">

                        </div>
                        <!-- END: Horizontal Menu -->                                <!-- BEGIN: Topbar -->
                        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-topbar__nav-wrapper">
                                <ul class="m-topbar__nav m-nav m-nav--inline">
                                    <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light"
                                        data-dropdown-toggle="click" data-dropdown-persistent="true" id="m_quicksearch"
                                        data-search-type="dropdown">
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>

                                            <div class="m-dropdown__inner ">
                                                <div class="m-dropdown__header">
                                                    <form class="m-list-search__form">
                                                        <div class="m-list-search__form-wrapper">
                                                                    <span class="m-list-search__form-input-wrapper">
                                                                        <input id="m_quicksearch_input" autocomplete="off"
                                                                               type="text" name="q"
                                                                               class="m-list-search__form-input" value=""
                                                                               placeholder="Procurar ...">
                                                                    </span>
                                                            <span class="m-list-search__form-icon-close"
                                                                  id="m_quicksearch_close">
                                                                        <i class="la la-remove"></i>
                                                                    </span>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__scrollable m-scrollable" data-max-height="300"
                                                         data-mobile-max-height="200">
                                                        <div class="m-dropdown__content"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width"
                                        data-dropdown-toggle="click" data-dropdown-persistent="true">

                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>

                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__header m--align-center"
                                                     style="background: url('{{ url('assets/app/media/img/misc/notification_bg.jpg') }}');
                                                             background-size: cover;">
                                                            <span class="m-dropdown__header-title">
                                                                 Nenhuma notificação
                                                            </span>
                                                    <span class="m-dropdown__header-subtitle">
                                                                Notificações
                                                            </span>
                                                </div>
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand"
                                                            role="tablist">
                                                            <li class="nav-item m-tabs__item">
                                                                <a class="nav-link m-tabs__link active" data-toggle="tab"
                                                                   href="#topbar_notifications_notifications" role="tab">
                                                                    Alertas
                                                                </a>
                                                            </li>
                                                            <li class="nav-item m-tabs__item">
                                                                <a class="nav-link m-tabs__link" data-toggle="tab"
                                                                   href="#topbar_notifications_events" role="tab">
                                                                    Eventos
                                                                </a>
                                                            </li>
                                                            <li class="nav-item m-tabs__item">
                                                                <a class="nav-link m-tabs__link" data-toggle="tab"
                                                                   href="#topbar_notifications_logs" role="tab">
                                                                    Logs
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active"
                                                                 id="topbar_notifications_notifications" role="tabpanel">

                                                            </div>
                                                            <div class="tab-pane" id="topbar_notifications_events"
                                                                 role="tabpanel">
                                                                <div class="m-scrollable" data-max-height="250"
                                                                     data-mobile-max-height="200">
                                                                    <div class="m-list-timeline m-list-timeline--skin-light">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="topbar_notifications_logs"
                                                                 role="tabpanel">
                                                                <div class="m-stack m-stack--ver m-stack--general"
                                                                     style="min-height: 180px;">
                                                                    <div class="m-stack__item m-stack__item--center m-stack__item--middle">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                        data-dropdown-toggle="click">
                                        <a href="#" class="m-nav__link m-dropdown__toggle">
                                                    <span class="m-topbar__userpic">
                                                        <img src="{{url('assets/app/media/img/users/user4.jpg')}}"
                                                             class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                                    </span>
                                            <span class="m-topbar__username m--hide">
                                                        Nick
                                                    </span>
                                        </a>

                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>

                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__header m--align-center"
                                                     style="background: url('{{url('assets/app/media/img/misc/user_profile_bg.jpg')}}'); background-size: cover;">
                                                    <div class="m-card-user m-card-user--skin-dark">
                                                        <div class="m-card-user__pic">
                                                            <img src="{{url('assets/app/media/img/users/user4.jpg')}}"
                                                                 class="m--img-rounded m--marginless" alt=""/>
                                                        </div>
                                                        <div class="m-card-user__details">
                                                                    <span class="m-card-user__name m--font-weight-500">
                                                                        {{ Auth::user()->name }}
                                                                    </span>
                                                            <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                                {{ Auth::user()->email }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav m-nav--skin-light">
                                                            <li class="m-nav__section m--hide">
                                                                        <span class="m-nav__section-text">
                                                                            Section
                                                                        </span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="header/profile.html" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                    <span class="m-nav__link-title">
                                                                                <span class="m-nav__link-wrap">
                                                                                    <span class="m-nav__link-text">
                                                                                        Meus dados
                                                                                    </span>

                                                                                </span>
                                                                            </span>
                                                                </a>
                                                            </li>

                                                            <li class="m-nav__item">
                                                                <a href="header/profile.html" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
                                                                                Mensagens
                                                                            </span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__separator m-nav__separator--fit"></li>


                                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                                            <li class="m-nav__item">
                                                                <a href="{{url('auth/logout')}}"
                                                                   class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                                    Logout
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- END: Topbar -->
                    </div>
                </div>
            </div>
        </header>
        <!-- END: Header -->
        <!-- begin::Body -->
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            <!-- BEGIN: Left Aside -->
            <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
                <i class="la la-close"></i>
            </button>
            <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
                <!-- BEGIN: Aside Menu -->
                <div
                        id="m_ver_menu"
                        class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
                        data-menu-vertical="true"
                        data-menu-scrollable="false" data-menu-dropdown-timeout="500">

                    {{--MENU LATERAL--}}
                    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow">
                        @foreach($menus as $menu)
                            @if($menu->name == "Cadastros" || $menu->name == "Usuários")
                                @if((Auth::user()->profile == "ADMINISTRADOR" || Auth::user()->profile == "DEPARTAMENTO"))
                                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                    @if($menu->sub_menus != "[]")  <!-- Caso não tenha sub menu é adicionado a url no hrf -->
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                    @else
                                        <a href="{{$menu->url}}" class="m-menu__link m-menu__toggle">
                                    @endif
                                            <i class="m-menu__link-icon {{$menu->icon}}" data-toggle="tooltip"
                                                       data-placement="top" title="{{$menu->name}}">
                                            </i>
                                            <span class="m-menu__link-text">{{$menu->name}}</span>
                                    @if($menu->sub_menus != "[]") <!-- Caso tenha sub menu é adicionado o incone -->
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    @endif
                                        </a>
                                    @if($menu->sub_menus != "[]") <!-- Caso tenha sub menu é adicionado  o Dropdown -->
                                        @foreach($menu->sub_menus as $sub_menu)
                                            @if($sub_menu->name == "Upload de Arquivos" || $sub_menu->name == "Gestão de Arquivos")
                                                @if(Auth::user()->profile == "ADMINISTRADOR" || Auth::user()->profile == "DEPARTAMENTO")
                                                    <div class="m-menu__submenu ">
                                                        <span class="m-menu__arrow"></span>
                                                        <ul class="m-menu__subnav">
                                                            <li class="m-menu__item " aria-haspopup="true">
                                                                <a href="{{$menu->url.$sub_menu->url}}" class="m-menu__link">
                                                                    <i class="m-menu__link-bullet {{$sub_menu->icon}}">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="m-menu__link-text">{{$sub_menu->name}}</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="m-menu__submenu ">
                                                    <span class="m-menu__arrow"></span>
                                                    <ul class="m-menu__subnav">
                                                        <li class="m-menu__item " aria-haspopup="true">
                                                            <a href="{{$menu->url.$sub_menu->url}}" class="m-menu__link">
                                                                <i class="m-menu__link-bullet {{$sub_menu->icon}}">
                                                                    <span></span>
                                                                </i>
                                                                <span class="m-menu__link-text">{{$sub_menu->name}}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif

                                        @endforeach
                                    @endif
                                            </a>
                                @endif
                            @else
                                <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"
                                    m-menu-submenu-toggle="hover" @if(Auth::user()->profile == "OPERADOR" && $menu->name == "Remessa") style="display:none" @endif>
                                @if($menu->sub_menus != "[]")  <!-- Caso não tenha sub menu é adicionado a url no hrf -->
                                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                @else
                                    <a href="{{$menu->url}}" class="m-menu__link m-menu__toggle">
                                @endif
                                        <i class="m-menu__link-icon {{$menu->icon}}" data-toggle="tooltip"
                                                   data-placement="top" title="{{$menu->name}}"></i>
                                        <span class="m-menu__link-text">{{$menu->name}}</span>
                                @if($menu->sub_menus != "[]") <!-- Caso tenha sub menu é adicionado o incone -->
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                @endif
                                    </a>
                                @if($menu->sub_menus != "[]") <!-- Caso tenha sub menu é adicionado  o Dropdown -->
                                    @foreach($menu->sub_menus as $sub_menu)
                                        @if($sub_menu->name == "Upload de Arquivos" || $sub_menu->name == "Gestão de Arquivos")
                                            @if(Auth::user()->profile == "ADMINISTRADOR" || Auth::user()->profile == "DEPARTAMENTO")
                                                <div class="m-menu__submenu">
                                                    <span class="m-menu__arrow"></span>
                                                    <ul class="m-menu__subnav">
                                                        <li class="m-menu__item " aria-haspopup="true">
                                                            <a href="{{$menu->url.$sub_menu->url}}" class="m-menu__link">
                                                                <i class="m-menu__link-bullet {{$sub_menu->icon}}">
                                                                    <span></span>
                                                                </i>
                                                                <span class="m-menu__link-text">{{$sub_menu->name}}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @else
                                            @if(Auth::user()->profile == "AGÊNCIA" && $sub_menu->name == "Operador" || Auth::user()->profile == "OPERADOR" && $sub_menu->name == "Agência")
                                            @else
                                                <div class="m-menu__submenu ">
                                                    <span class="m-menu__arrow"></span>
                                                    <ul class="m-menu__subnav">
                                                        <li class="m-menu__item " aria-haspopup="true">
                                                            <a href="{{$menu->url.$sub_menu->url}}" class="m-menu__link">
                                                                <i class="m-menu__link-bullet {{$sub_menu->icon}}">
                                                                    <span></span>
                                                                </i>
                                                                <span class="m-menu__link-text">{{$sub_menu->name}}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
                <!-- END: Aside Menu -->
            </div>

            <div class="m-grid__item m-grid__item--fluid m-wrapper">

                <!-- BEGIN: Subheader -->
                <div class="m-subheader ">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="m-subheader__title ">@yield('title')</h3>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="m-content">

                    @yield('content')

                </div>
            </div>
        </div>
        <!-- By Wagner - Adcionei essa div porque o scroll estava enorme -->
        <!-- END: Left Aside -->
    </div>
    <!-- end:: Page -->
    <!-- begin::Quick Sidebar -->
    <div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
        <div class="m-quick-sidebar__content m--hide">
            <span id="m_quick_sidebar_close" class="m-quick-sidebar__close">
                <i class="la la-close"></i>
            </span>
            <ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_quick_sidebar_tabs_messenger"
                       role="tab">
                        Messages
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_settings" role="tab">
                        Settings
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_logs" role="tab">
                        Logs
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active m-scrollable" id="m_quick_sidebar_tabs_messenger" role="tabpanel">
                    <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
                        <div class="m-messenger__messages">
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="{{url('assets/app/media/img/users/user3.jpg')}}" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Hi Bob. What time will be the meeting ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Hi Megan. It's at 2.30PM
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="{{url('assets/app/media/img/users/user3.jpg')}}" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Will the development team be joining ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Yes sure. I invited them as well
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__datetime">
                                2:30PM
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="{{url('assets/app/media/img/users/user3.jpg')}}" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Noted. For the Coca-Cola Mobile App project as well ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Yes, sure.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Please also prepare the quotation for the Loop CRM project as well.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__datetime">
                                3:15PM
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-no-pic m--bg-fill-danger">
                                                <span>
                                                    M
                                                </span>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Noted. I will prepare it.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Thanks Megan. I will see you later.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="{{url('assets/app/media/img/users/user3.jpg')}}" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Sure. See you in the meeting soon.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-messenger__seperator"></div>
                        <div class="m-messenger__form">
                            <div class="m-messenger__form-controls">
                                <input type="text" name="" placeholder="Type here..." class="m-messenger__form-input">
                            </div>
                            <div class="m-messenger__form-tools">
                                <a href="" class="m-messenger__form-attachment">
                                    <i class="la la-paperclip"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane  m-scrollable" id="m_quick_sidebar_tabs_settings" role="tabpanel">
                    <div class="m-list-settings">
                        <div class="m-list-settings__group">
                            <div class="m-list-settings__heading">
                                General Settings
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Email Notifications
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" checked="checked" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Site Tracking
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            SMS Alerts
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Backup Storage
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Audit Logs
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" checked="checked" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                        </div>
                        <div class="m-list-settings__group">
                            <div class="m-list-settings__heading">
                                System Settings
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            System Logs
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Error Reporting
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Applications Logs
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Backup Servers
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" checked="checked" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                            <div class="m-list-settings__item">
                                        <span class="m-list-settings__item-label">
                                            Audit Logs
                                        </span>
                                <span class="m-list-settings__item-control">
                                            <span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane  m-scrollable" id="m_quick_sidebar_tabs_logs" role="tabpanel">
                    <div class="m-list-timeline">
                        <div class="m-list-timeline__group">
                            <div class="m-list-timeline__heading">
                                System Logs
                            </div>
                            <div class="m-list-timeline__items">
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        12 new users registered
                                        <span class="m-badge m-badge--warning m-badge--wide">
                                                    important
                                                </span>
                                    </a>
                                    <span class="m-list-timeline__time">
                                                Just now
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        System shutdown
                                    </a>
                                    <span class="m-list-timeline__time">
                                                11 mins
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
                                    <a href="" class="m-list-timeline__text">
                                        New invoice received
                                    </a>
                                    <span class="m-list-timeline__time">
                                                20 mins
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Database overloaded 89%
                                        <span class="m-badge m-badge--success m-badge--wide">
                                                    resolved
                                                </span>
                                    </a>
                                    <span class="m-list-timeline__time">
                                                1 hr
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        System error
                                    </a>
                                    <span class="m-list-timeline__time">
                                                2 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Production server down
                                        <span class="m-badge m-badge--danger m-badge--wide">
                                                    pending
                                                </span>
                                    </a>
                                    <span class="m-list-timeline__time">
                                                3 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Production server up
                                    </a>
                                    <span class="m-list-timeline__time">
                                                5 hrs
                                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="m-list-timeline__group">
                            <div class="m-list-timeline__heading">
                                Applications Logs
                            </div>
                            <div class="m-list-timeline__items">
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        New order received
                                        <span class="m-badge m-badge--info m-badge--wide">
                                                    urgent
                                                </span>
                                    </a>
                                    <span class="m-list-timeline__time">
                                                7 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        12 new users registered
                                    </a>
                                    <span class="m-list-timeline__time">
                                                Just now
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        System shutdown
                                    </a>
                                    <span class="m-list-timeline__time">
                                                11 mins
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
                                    <a href="" class="m-list-timeline__text">
                                        New invoices received
                                    </a>
                                    <span class="m-list-timeline__time">
                                                20 mins
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Database overloaded 89%
                                    </a>
                                    <span class="m-list-timeline__time">
                                                1 hr
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        System error
                                        <span class="m-badge m-badge--info m-badge--wide">
                                                    pending
                                                </span>
                                    </a>
                                    <span class="m-list-timeline__time">
                                                2 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Production server down
                                    </a>
                                    <span class="m-list-timeline__time">
                                                3 hrs
                                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="m-list-timeline__group">
                            <div class="m-list-timeline__heading">
                                Server Logs
                            </div>
                            <div class="m-list-timeline__items">
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Production server up
                                    </a>
                                    <span class="m-list-timeline__time">
                                                5 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        New order received
                                    </a>
                                    <span class="m-list-timeline__time">
                                                7 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        12 new users registered
                                    </a>
                                    <span class="m-list-timeline__time">
                                                Just now
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        System shutdown
                                    </a>
                                    <span class="m-list-timeline__time">
                                                11 mins
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
                                    <a href="" class="m-list-timeline__text">
                                        New invoice received
                                    </a>
                                    <span class="m-list-timeline__time">
                                                20 mins
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Database overloaded 89%
                                    </a>
                                    <span class="m-list-timeline__time">
                                                1 hr
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        System error
                                    </a>
                                    <span class="m-list-timeline__time">
                                                2 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Production server down
                                    </a>
                                    <span class="m-list-timeline__time">
                                                3 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">
                                        Production server up
                                    </a>
                                    <span class="m-list-timeline__time">
                                                5 hrs
                                            </span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">
                                        New order received
                                    </a>
                                    <span class="m-list-timeline__time">
                                                1117 hrs
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end::Quick Sidebar -->
    <!-- begin::Scroll Top -->
    <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500"
         data-scroll-speed="300">
        <i class="la la-arrow-up"></i>
    </div>

    <div class="modal fade show" id="on_error" tabindex="-1" role="dialog" aria-labelledby="on_errorModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('titles.error')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="description_error"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="clear" class="btn btn-danger"
                            data-dismiss="modal">{{__('buttons.close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade show" id="on_done_data" tabindex="-1" role="dialog" aria-labelledby="on_done_dataModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">{{__('labels.success')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Cadastrado com sucesso</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="redirect()"
                            data-dismiss="modal">{{__('buttons.close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="basepath" value="{{url('/')}}">
    <!-- Only to avoid Vue #app not found error -->
    <div id="app"></div>
    <!-- end::Scroll Top -->

    @yield('aftercontent')


    <!-- begin::Footer -->
    <footer class="m-grid__item m-footer footer">
        <div class="m-container m-container--fluid m-container--full-height m-page__container">
            <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                    <span class="m-footer__copyright">2018 &copy; ADDRESS</span>
                </div>
            </div>
        </div>
    </footer>
    <!-- end::Footer -->

    <!-- Internet Explorer Support -->
    <script src="{{ mix('/js/polyfill.min.js') }}"></script>

    <!--begin::Base Scripts -->
    <script src="{{ mix('/js/manifest.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js') }}" type="text/javascript"></script>

    <script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/noCommonJS.libs.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/custom.scripts.js') }}" type="text/javascript"></script>

    @yield('scripts')
    <!--end::Page Snippets -->

    <!-- Flash Messages if exists -->
    @component('flashmessages')
    @endcomponent

</body>
<!-- end::Body -->
</html>

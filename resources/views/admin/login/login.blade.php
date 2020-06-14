<!DOCTYPE html>
<html lang="en">
<!--================================================================================
  Item Name: Materialize - Material Design Admin Template
  Version: 4.0
  Author: PIXINVENT
  Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================ -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>Login Page | Materialize - Material Design Admin Template</title>
    <!-- Favicons-->
    <link rel="icon" href="{{asset('style/images/favicon/favicon-32x32.png')}}" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="{{asset('style/images/favicon/apple-touch-icon-152x152.png')}}">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    <link href="{{asset('style/css/themes/semi-dark-menu/materialize.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/css/themes/semi-dark-menu/style.css')}}" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <link href="{{asset('style/css/custom/custom.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/css/layouts/page-center.css')}}" type="text/css" rel="stylesheet">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="{{asset('style/vendors/perfect-scrollbar/perfect-scrollbar.css')}}" type="text/css" rel="stylesheet">
</head>
<body class="cyan">
<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<!-- End Page Loading -->
<div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
        <form class="login-form" method="post" action="{{ route('admin.login.post') }}">
            @csrf
            @if(session()->has('error'))
                <div id="card-alert" class="card gradient-45deg-red-pink">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">error</i> {{session()->get('error')}}</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="input-field col s12 center">
                    <img src="{{asset('style/images/logo/login-logo.png')}}" alt="" class="circle responsive-img valign profile-image-login">
                    <p class="center login-form-text">{{trans('admin.services')}}</p>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="material-icons prefix pt-5">person_outline</i>
                    <input id="username" type="email" name="email" value="{{ old('email') }}">
                    <label for="username" class="center-align">{{trans('admin.enter email')}}</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="material-icons prefix pt-5">lock_outline</i>
                    <input id="password" type="password" name="password">
                    <label for="password">{{trans('admin.enter password')}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l12 ml-2 mt-3">
                    <input type="checkbox" id="remember-me" name="remember"/>
                    <label for="remember-me">{{trans('admin.remember me')}}</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button type="submit" class="btn waves-effect waves-light col s12">{{trans('admin.login')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- ================================================
Scripts
================================================ -->
<!-- jQuery Library -->
<script type="text/javascript" src="{{asset('style/vendors/jquery-3.2.1.min.js')}}"></script>
<!--materialize js-->
<script type="text/javascript" src="{{asset('style/js/materialize.min.js')}}"></script>
<!--scrollbar-->
<script type="text/javascript" src="{{asset('style/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="{{asset('style/js/plugins.js')}}"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="{{asset('style/js/custom-script.js')}}"></script>
</body>
</html>

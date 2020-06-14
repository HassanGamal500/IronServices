<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('page_title')</title>
    <!-- Favicons-->
    <link rel="icon" href="{{asset('style/images/favicon/favicon-32x32.png')}}" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="{{asset('style/images/favicon/apple-touch-icon-152x152.png')}}">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    <link href="{{asset('style/css/slick.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/css/slick-theme.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/css/themes/semi-dark-menu/materialize.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/css/themes/semi-dark-menu/style.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/css/style.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/css/mystyle.css')}}" type="text/css" rel="stylesheet">

    <!-- Custome CSS-->
    <link href="{{asset('style/css/custom/custom.css')}}" type="text/css" rel="stylesheet">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="{{asset('style/vendors/prism/prism.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/vendors/perfect-scrollbar/perfect-scrollbar.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/vendors/sweetalert/dist/sweetalert.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/vendors/data-tables/css/jquery.dataTables.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/vendors/jvectormap/jquery-jvectormap.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('style/vendors/flag-icon/css/flag-icon.min.css')}}" type="text/css" rel="stylesheet">
    <!--Select 2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">--}}
{{--    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.semanticui.min.css">--}}
</head>

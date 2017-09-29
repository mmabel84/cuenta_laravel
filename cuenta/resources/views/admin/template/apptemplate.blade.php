<html lang="{{ config('app.locale') }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link type="image/x-icon" href="{{asset('favicon.ico')}}" rel="shortcut icon">
        <title>@yield('app_title')</title>
        @section('app_css')
            <!-- Fonts -->
            <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
             <!-- Font Awesome -->
            <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
            <!-- NProgress -->
            <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
            <!-- iCheck -->
            <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
                <!-- bootstrap-progressbar -->
           <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.css') }}" rel="stylesheet"> 
           <!-- Custom Theme Style --> 
           <link href="{{ asset('build/css/custom.css') }}" rel="stylesheet">
            
        @show
    </head>
    @yield('app_body')
</html>
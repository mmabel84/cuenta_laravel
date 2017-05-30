<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Cuenta')</title>


        <!-- Fonts -->
        <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
   		 <!-- Font Awesome -->
    	<link href="{{ asset('vendors/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
   		<!-- NProgress -->
    	<link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">

    	<!-- Custom Theme Style -->
    	<link href="{{ asset('build/css/custom.css') }}" rel="stylesheet">

    	

		
		    <!-- jQuery -->
	    <script src="{{ asset('vendors/jquery/dist/jquery.js') }}"></script>
	    <!-- Bootstrap -->
	    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.js') }}"></script>
	    <!-- FastClick -->
	    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
	    <!-- NProgress -->
	    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
	    <!-- Chart.js -->
	    <script src="{{ asset('vendors/echarts/dist/echarts.js') }}"></script>
	    <script src="{{ asset('vendors/Chart.js/dist/Chart.js') }}"></script>
    	<!-- Custom Theme Scripts -->
    	<script src="{{ asset('build/js/custom.js') }}"></script>  
    	<script src="{{ asset('js/custom.js') }}"></script>      

    	<section>@yield('formjs')</section>

    	



    </head>
    <body class="nav-md">
    	<div class="container body">
      		<div class="main_container">
                @include('admin.template.sidenavbar')
                <div class="right_col" role="main">
                    <div class="page-title">
                      <div class="title_left">
                        <h3>Cuenta <small></small></h3>
                      </div>

                      <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
  		    	     <div class="row">  
    		    	       <section>@yield('content')</section>
                  </div>
                </div>
    		

            </div>
		</div>

    	
        
    </body>
</html>


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

    	<section>@yield('formcss')</section>

    </head>

    <body class="nav-md">
    	<div class="container body">
      		<div class="main_container">
                
               @section('app_left_menu')
                  <div class="col-md-3 left_col">
                      <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                          <a href="index.html" class="site_title"><span>{{ config('app.name') }}</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                          
                        <div class="profile_info">
                            <span><b>Bienvenido</b></span>
                            <strong>{{ Auth::user()->name }}</strong>
                          </div>
                        </div>
                        <!-- /menu profile quick info -->
                        <br />
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                          <div class="menu_section">
                              <ul class="nav side-menu">
                                
                                  <li><a href="/"><i class="fa fa-dashboard"></i> <b>Panel</b> </a>
                                  <li><a href="{{ URL::to('empresas') }}"><i class="fa fa-building"></i> <b>Empresas</b> </a>
                                  <li><a href="/listarfc"><i class="fa fa-building-o"></i><b> RFCs</b> </a>
                                  <li><a href="/listausuario"><i class="fa fa-users"></i> <b>Usuarios</b></a>
                                  <li><a href="/listaproveedor"><i class="fa fa-users"></i> <b>Proveedores</b> </a>
                                  <li><a href="/listainstancia"><i class="fa fa-database"></i> <b>Instancias</b> </a>
                                  <li><a href="/"><i class="fa fa-gears"></i> <b>Respaldos</b> </a>
                                  <li><a href="/"><i class="fa fa-wrench"></i> <b>Configuración</b> </a>

                                  </li>
                               
                              </ul>
                          </div>

                  

                </div>  
                <!-- /sidebar menu --> 
                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                  
                </div>
                <!-- /menu footer buttons -->
              </div>
            </div>
            @show



           

            @section('app_top_navigation')
          <!-- top navigation -->
                <div class="top_nav">
                  <div class="nav_menu">
                    <nav>
                      <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                      </div>

                      <ul class="nav navbar-nav navbar-right">
                        <li class="">
                          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="" alt="">{{ Auth::user()->name }}
                            <span class=" fa fa-angle-down"></span>
                          </a>
                          <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li><a href="javascript:;"> Perfil</a></li>
                            @if (Auth::guest())
                                  <li><a href="{{ route('login') }}">Login</a></li>
                                  <li><a href="{{ route('register') }}">Register</a></li>
                              @else
                                  <li class="dropdown">
                                          <li>
                                              <a href="{{ route('logout') }}"
                                                  onclick="event.preventDefault();
                                                           document.getElementById('logout-form').submit();">
                                                  Salir
                                              </a>

                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                  {{ csrf_field() }}
                                              </form>
                                          </li>
                                  </li>
                              @endif
                          </ul>
                        </li>

                        
                      </ul>
                    </nav>
                  </div>
                </div>
            <!-- /top navigation -->
        @show

        <!-- page content -->
                <div class="right_col" role="main">
                  <div class="container">
                  
                        @yield('content')
                   
                  </div>
                </div>
            <!-- /page content -->
        <footer></footer>


      </div>

    </div>



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
       
      <script src="{{ asset('/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.js') }}"></script>
      <script src="{{ asset('/vendors/gauge.js/dist/gauge.js') }}"></script>
      <script src="{{ asset('build/js/custom.js') }}"></script>
      <section>@yield('formjs')</section>

    </body>
</html>

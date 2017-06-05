@extends('admin.template.apptemplate')

@section('app_title','Control App')

@section('app_css')
    @parent
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">    
   <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.css') }}" rel="stylesheet">
@endsection

@section('app_body')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                
                @section('app_left_menu')
                    <div class="col-md-3 left_col">
                        <div class="left_col scroll-view">
                          <div class="navbar nav_title" style="border: 0;">
                            <a href="index.html" class="site_title"><i class="fa fa-creative-commons"></i> <span>{{ config('app.name') }}</span></a>
                          </div>
                          <div class="clearfix"></div>
                          <!-- menu profile quick info -->
                          <div class="profile clearfix">
                            
                            <div class="profile_info">
                              <span>Hola</span>
                              <h2><strong>{{ Auth::user()->name }}</strong></h2>
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
                                  <li><a href="{{ URL::to('usuarios') }}"><i class="fa fa-users"></i> <b>Usuarios</b></a>
                                  <li><a href="{{ URL::to('apps') }}"><i class="fa fa-database"></i> <b>Aplicaciones</b> </a>
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
                                    <li><a href="javascript:;"> Profile</a></li>
                                    @if (Auth::guest())
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @else
                                        <li class="dropdown">
                                                <li>
                                                    <a href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                        Logout
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
                             @yield('content')
                        </div>
                    <!-- /page content -->
                <footer></footer>


            </div>

        </div>

        @section('app_js')
            <!-- jQuery -->
            <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
            <!-- Bootstrap -->
            <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
            <!-- FastClick -->
            <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
            <!-- NProgress -->
            <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
            <!-- iCheck -->
            <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
        @show
    </body>
@endsection
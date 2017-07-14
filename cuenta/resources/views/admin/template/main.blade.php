@extends('admin.template.apptemplate')

@section('app_title','Cuenta App')

@section('app_css')
    @parent
      

   
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    
    

@endsection

@section('app_body')
    <body class="nav-md" style="background-color: #072542">
        <div class="container body">
            <div class="main_container" style="background-color: #072542">
                
                @section('app_left_menu')
                    <div class="col-md-3 left_col" style="background-color: #072542">
                        <div class="left_col scroll-view" style="background-color: #072542">
                          <div class="navbar nav_title" style="border: 0; background-color: #072542;">
                            <a href="/" class="site_title"><img height="60px" src="{{asset('logo_advans_head.png')}}"><span>{{ config('app.name') }}</span></a>
                          </div>
                          <div class="clearfix"></div>
                          <!-- menu profile quick info -->
                          <div class="profile clearfix">
                            
                            <div class="profile_info">
                              <!--<span><b>BIENVENIDO</b></span>
                              <h2><strong>{{ Auth::user()->name }}</strong></h2>-->
                            </div>
                          </div>
                          <!-- /menu profile quick info -->
                          <br />
                          <!-- sidebar menu -->
                           <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                          <div class="menu_section">
                              <ul class="nav side-menu">
                                
                                  <li><a href="/"><i class="fa fa-dashboard"></i> INICIO </a></li>
                                   
                                  @role('gestor.mantenimiento')
                                   <li><a><i class="fa fa-cogs"></i> MANTENIMIENTO <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                      @permission('leer.empresa')
                                      <li><a href="{{ URL::to('empresas') }}">EMPRESAS</a></li>
                                      @endpermission
                                      @permission('leer.usuario')
                                      <li><a href="{{ URL::to('usuarios') }}">USUARIOS</a></li>
                                      @endpermission
                                      @permission('leer.aplicacion')
                                      <li><a href="{{ URL::to('apps') }}">APLICACIONES</a></li>
                                      @endpermission
                                      @permission('leer.respaldo')
                                      <li><a href="{{ URL::to('backups') }}">RESPALDOS</a></li>
                                      @endpermission
                                      @permission('leer.certificado')
                                      <li><a href="{{ URL::to('certificados') }}">CERTIFICADOS</a></li>
                                      @endpermission
                                      
                                    </ul>
                                  </li>
                                  @endrole

                                  <!--<li><a href="{{ URL::to('empresas') }}"><i class="fa fa-building"></i> EMPRESAS </a></li>
                                  <li><a href="{{ URL::to('apps') }}"><i class="fa fa-database"></i> APLICACIONES </a></li>-->

                                  <li><a><i class="fa fa-wrench"></i> CONFIGURACIÓN <span class="fa fa-chevron-down"></span></a>
                                      <ul class="nav child_menu">
                                        <li><a href="{{ URL::to('paqs') }}">LÍNEA DE TIEMPO CONTRATADA</a></li>
                                        <li><a href="{{ URL::to('appsasign') }}">APLICACIONES CONTRATADAS</a></li>
                                          @permission('leer.rol')
                                          <li><a href="{{ URL::to('roles') }}">ROLES</a></li>
                                          @endpermission
                                          @permission('leer.permiso')
                                          <li><a href="{{ URL::to('permisos') }}">PERMISOS</a></li>
                                          @endpermission
                                        
                                      </ul>


                                  </li>
                                  @permission('leer.bitácora')
                                  <li><a href="{{ URL::to('bitacoras') }}"><i class="fa fa-eye"></i> BITÁCORA </a></li>
                                  @endpermission
                              </ul>
                          </div>

                            

                          </div>
                          <!-- /sidebar menu -->
                          <!-- /menu footer buttons -->
                          
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
                                    <span><b>BIENVENIDO </b></span>
                                    <img src=" {{ Auth::user()->users_pic ? asset('storage/'.Auth::user()->users_pic) : asset('default_avatar_male.jpg')}}" alt="">{{ Auth::user()->name }}
                                    <span class=" fa fa-angle-down"></span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <!--<li><a href="javascript:;"> Profile</a></li>-->
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
                          <div class="">
                             @yield('content')
                          </div>
                        </div>
                    <!-- /page content -->
              @section('app_footer')
              <footer>
                  <div class="pull-right">
                      <b>Soluciones Advans S.A de C.V © 2017 Derechos Reservados</b>  </div>
                    
                  <div class="span6">
                          <div class="content">
                            <nav id="sub-menu">
                                <ul>
                                  <li><a href="http://www.advans.mx/content/aviso-de-privacidad" target='_blank'><b>Aviso de Privacidad</b></a></li>
                                  <li><a href="http://www.advans.mx/content/terminos-y-condiciones" target='_blank'><b>Términos y Condiciones</b></a></li>
                                </ul>
                            </nav>
                          </div>  
                    
                  </div>
                  <div class="clearfix"></div>
            </footer>

            
            @show


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
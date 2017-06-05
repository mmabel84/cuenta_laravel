 		

 			 <!-- sidebar menu -->
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"> <span>Cuenta</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2>{{ Auth::user()->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menús</h3>
                <ul class="nav side-menu">
                  
                  <li><a href="/"><i class="fa fa-dashboard"></i> Panel principal </a>
                  <li><a href="{{ URL::to('empresas') }}"><i class="fa fa-building"></i> Empresas </a>
                  <li><a href="/listarfc"><i class="fa fa-building-o"></i> RFCs de empresa </a>
                  <li><a href="/listausuario"><i class="fa fa-users"></i> Usuarios</a>
                  <li><a href="/listaproveedor"><i class="fa fa-users"></i> Proveedores </a>
                  <li><a href="/listainstancia"><i class="fa fa-database"></i> Instancias </a>
                  <li><a href="/"><i class="fa fa-gears"></i> Generar respaldo </a>
                  <li><a href="/"><i class="fa fa-wrench"></i> Configuración de la cuenta </a>

                  </li>
                 
               
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

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
            <!-- /sidebar menu -->

 



            
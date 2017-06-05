@extends('admin.template.main')

@section('title')
      Panel de cuenta
@endsection




@section('content')

        <div class="">

              <div class="x_title">
                  <h4>Aplicaciones</h4>
              </div>

              <div class="col-md-3 col-sm-3 col-xs-12">
                <select class="select2_single form-control" tabindex="-1">
                  <option>Seleccione una empresa</option>
                  <option value="AK">Empresa 1-1111111</option>
                  <option value="HI">Empresa 2-2222222</option>
                  <option value="CA">Empresa 3-3333333</option>
                  
                </select>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                 
                  <a href="#" data-toggle="tooltip" data-placement="right" title="PLD"><i class="fa fa-money fa-3x" style="color:#191970;"></i></a>
                  &nbsp;
                  &nbsp;
                  <a href="#" data-toggle="tooltip" data-placement="right" title="Contabilidad"><i class="fa fa-bank fa-3x" style="color: #191970;"></i></a>
                  &nbsp;
                  &nbsp;
                  <a href="#" data-toggle="tooltip" data-placement="right" title="Bóveda"><i class="fa fa-archive fa-3x" style="color: #191970;"></i></a>
                  &nbsp;
                  &nbsp;
                  <a href="#" data-toggle="tooltip" data-placement="right" title="Notaría"><i class="fa fa-briefcase fa-3x" style="color: #191970;"></i></a>
                  &nbsp;
                  &nbsp;
                  <a href="#" data-toggle="tooltip" data-placement="right" title="Control de calidad"><i class="fa fa-cc fa-3x" style=" color:#191970;"></i></a>
                  &nbsp;
                  &nbsp;
                  <a href="#" data-toggle="tooltip" data-placement="right" title="Nómina"><i class="fa fa-table fa-3x" style=" color:#191970;"></i></a>
              </div>

               <div class="col-md-6 col-sm-6 col-xs-12">
               <p></p>
              </div>
              <br>
              <br>
              <br>
              <div>
                <div class="x_title">
                  <h4>Análisis de tiempo</h4>
              </div>

              <div class="progress">
                <div class="progress-bar-success" role="progressbar" aria-valuenow="70"
                aria-valuemin="0" aria-valuemax="100" style="width:70%">
                  70%
                </div>
              </div>

               

              </div>
              
              
                                    
                <div class="clearfix"></div>
                <br>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                    </div>
                          

               <div class="x_title">
                      <h4>Cuenta</h4>
                </div>

                <div class=" tile_count">

                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">

                  <span class="count_top"><b style=" color:#191970;">Gigas asignados</b></span>
                  <div class="count"><b style=" color:#191970;">150</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#191970;">Empresas asignadas</b></span>
                  <div class="count"><b style=" color:#191970;">10</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#191970;">Empresas creadas</b></span>
                  <div class="count"><b style=" color:#191970;">3</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#191970;">Aplicaciones</b></span>
                  <div class="count"><b style=" color:#191970;">3</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#191970;">usuarios creados</b></span>
                  <div class="count"><b style=" color:#191970;">5</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#191970;">Backups generados</b></span>
                  <div class="count"><b style=" color:#191970;">7</b></div>
                </div>
                
              </div>


                <div class="clearfix"></div>


                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Tiempo consumido por paquete</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_mini_pie" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>



                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Gigas consumidos totales</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_pie" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>


                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Gigas consumidos por aplicación</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_bar_horizontal" style="height:370px;"></div>

                      </div>
                    </div>
                  </div>

                 



                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Bóveda</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="mainb" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>CFDI Validados</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li> 
                           </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_donut" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>


                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Contabilidad</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="mainb1" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>


                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Pólizas no aprobadas</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_donut1" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>     


                  
                <div class="clearfix"></div>
                <br />
              

            </div>




            


@endsection

@section('app_js')
    @parent

    <!-- Chart.js -->
      <script src="{{ asset('vendors/echarts/dist/echarts.js') }}"></script>
      <script src="{{ asset('vendors/Chart.js/dist/Chart.js') }}"></script>
      <script src="{{ asset('/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.js') }}"></script>
      <script src="{{ asset('/vendors/gauge.js/dist/gauge.js') }}"></script>
      <script src="{{ asset('build/js/custom.js') }}"></script>

@endsection

@extends('admin.template.main')




@section('title')
      Panel de cuenta
@endsection

@section('content')

 <!-- page content -->
          
          

            <div class="col-md-12">
              <div class="panel panel-body">

                <div class="x_title">
                  <h4>Aplicaciones</h4>
                        

                </div>
                    
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              
                            </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                              <select class="select2_single form-control" tabindex="-1">
                                <option>Seleccione una empresa</option>
                                <option value="AK">Empresa 1-1111111</option>
                                <option value="HI">Empresa 2-2222222</option>
                                <option value="CA">Empresa 3-3333333</option>
                                
                              </select>
                            </div>
                          </div>

                    <div class="row">
                    <div class="col-xs-3">

                      <div class="dashboard-widget-content">

                      <input type="text" id="act_value2" value="25" style="visibility:hidden">
                      <input type="text" id="max_value2" value="40" style="visibility:hidden">
                        <div class="sidebar-widget">
                        <button type="button" class="btn btn-round btn-primary">Contabilidad</button>
                          <canvas width="140" height="80" id="chart_gauge_02" class="" style="width: 160px; height: 100px;"></canvas>
                              <div class="goal-wrapper">
                                <span class="gauge-value pull-left"></span>
                                <span id="gauge-text2" class="gauge-value pull-left">25</span>
                                <span id="goal-text2" class="goal-value pull-right">50</span>
                              </div>                    

                        </div>
                      </div>
                    </div>

                    <div class="col-xs-3">

                      <div class="dashboard-widget-content">

                      <input type="text" id="act_value3" value="70" style="visibility:hidden">
                      <input type="text" id="max_value3" value="90" style="visibility:hidden">
                        <div class="sidebar-widget">
                        <button type="button" class="btn btn-round btn-primary">Bóveda</button>
                          <canvas width="140" height="80" id="chart_gauge_03" class="" style="width: 160px; height: 100px;"></canvas>
                              <div class="goal-wrapper">
                                <span class="gauge-value pull-left"></span>
                                <span id="gauge-text3" class="gauge-value pull-left">70</span>
                                <span id="goal-text3" class="goal-value pull-right">90</span>
                              </div>                    

                        </div>
                      </div>
                    </div>


                    <div class="col-xs-3">

                      <div class="dashboard-widget-content">

                      <input type="text" id="act_value4" value="5" style="visibility:hidden">
                      <input type="text" id="max_value4" value="30" style="visibility:hidden">
                        <div class="sidebar-widget">
                        <button type="button" class="btn btn-round btn-primary">PLD</button>
                          <canvas width="140" height="80" id="chart_gauge_04" class="" style="width: 160px; height: 100px;"></canvas>
                              <div class="goal-wrapper">
                                <span class="gauge-value pull-left"></span>
                                <span id="gauge-text4" class="gauge-value pull-left">5</span>
                                <span id="goal-text4" class="goal-value pull-right">30</span>
                              </div>                    

                        </div>
                      </div>
                    </div>
                  
                                    
                  <div class="clearfix"></div>

              </div>
            </div>
            </div>

            <div class="x_title">
                  <h4>Cuenta</h4>
                        

            </div>

            <div class=" tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>Gigas asignados</span>
              <div class="count">150</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>Empresas asignadas</span>
              <div class="count">10</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Empresas creadas</span>
              <div class="count">3</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Aplicaciones</span>
              <div class="count">3</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Usuarios creados</span>
              <div class="count">5</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Backups generados</span>
              <div class="count">7</div>
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

        <!-- /page content -->
  

@endsection

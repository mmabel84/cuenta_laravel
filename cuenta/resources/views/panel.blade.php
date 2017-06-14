@extends('admin.template.main')

@section('title')
      Panel de cuenta
@endsection

@section('app_css')
    @parent
    <!-- Datatables -->
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <style type="text/css">
      .disabled {
                 pointer-events: none;
                 cursor: default;
                 opacity: 0.6;
                 color:grey;
              }

    </style>


@endsection



@section('content')

        <div class="">


            <div class=" tile_count">

                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">

                  <span class="count_top"><b style=" color:#053666;">Gigas asignados</b></span>
                  <div class="count"><b style=" color:#053666;">{{ $gigas }}</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#053666;">Empresas asignadas</b></span>
                  <div class="count"><b style=" color:#053666;">{{ $rfc }}</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#053666;">Empresas creadas</b></span>
                  <div class="count"><b style=" color:#053666;">{{ $rfccreados }}</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#053666;">Aplicaciones contratadas</b></span>
                  <div class="count"><b style=" color:#053666;">{{ $apps }}</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#053666;">Usuarios creados</b></span>
                  <div class="count"><b style=" color:#053666;">{{ $usrs }}</b></div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><b style=" color:#053666;">BD generadas</b></span>
                  <div class="count"><b style=" color:#053666;">{{ $bdapps }}</b></div>
                </div>
                
              </div>


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                          <h2>Acceso a aplicaciones</h2>
                          <div class="clearfix"></div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12">
                  
                  <select class="select2_single form-control col-md-6 col-xs-12" name="select_empresa" id="select_empresa" onchange="onSelectEmpresa(this)">
                            <option value="null">Seleccione una empresa ...</option>
                            @foreach($emps as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->empr_nom }}</option>
                            @endforeach
                          </select>
                </div>
                <input type="hidden" id="iconsapp" name="iconsapp" value="{{ $appvisible }}">
                <div class="col-md-9 col-sm-9 col-xs-12" id="diviscons">
   
                <!--    <a href="#" data-toggle="tooltip" data-placement="right" title="PLD" id="pld"><i class="fa fa-money fa-3x" style="color:#053666;"></i></a>
                    &nbsp;
                    &nbsp;
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Contabilidad" id="cont"><i class="fa fa-bank fa-3x" style="color: #053666;"></i></a>
                    &nbsp;
                    &nbsp;
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Bóveda" id="bov"><i class="fa fa-archive fa-3x" style="color: #053666;"></i></a>
                    &nbsp;
                    &nbsp;
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Notaría" id="not"><i class="fa fa-briefcase fa-3x" style="color: #053666;" ></i></a>
                    &nbsp;
                    &nbsp;
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Control de calidad" id="cc"><i class="fa fa-tasks fa-3x" style=" color:#053666;"></i></a>
                    &nbsp;
                    &nbsp;
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Nómina" id="nom"><i class="fa fa-table fa-3x" style=" color:#053666;"></i></a>-->
                </div>
                 <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
             </div>

              <div class="col-md-9 col-sm-9 col-xs-12">

                <div class="x_panel">
                  <div class="x_title">
                      <h2>Análisis de tiempo de paquete contratado</h2>
                      <div class="clearfix"></div>
                  </div>
                  <br>
                  <div class="col-md-6">
                      <div class="progress" >
                        <div class="progress-bar" data-transitiongoal="{{ $porc_final }}">{{ $porc_final }}%</div>
                      </div>
                      <label style=" color:#191970">% de tiempo consumido vs fecha de fin 25/10/2017</label>

                   </div>

                    <div class="col-md-6">
                        <div class="progress" >
                          <div class="progress-bar" data-transitiongoal="{{ $porc_cad }}">{{ $porc_cad }}%</div>
                        </div>
                        <label style=" color:#191970">% de tiempo consumido vs fecha de caducidad 20/10/2017</label>

                    </div>

                </div>
              </div>

              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel">
                <div class="x_title">
                            <h2>Consulta de Artículo 69-B</h2>
                            <div class="clearfix"></div>
                  </div>
                 
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="Ingrese RFC...">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary">Ir</button>
                        </span>

                     </div>
                      <br>
                      <label style="color:#D10E0E;">RFC marcado!</label>
                      <label style="color:#189847;">RFC limpio!</label>
                 </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="x_title">
                            <h2>Novedades y Promociones</h2>
                            <div class="clearfix"></div>
                 </div>

                 <div class="x_content">
                    <article class="media event">
                      <a class="pull-left date" >
                        <p class="month" style="color: #053666"><b>Abril</b></p>
                        <p class="day" style="color: #053666">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#" style="color: #053666">Actualización de bóveda.</a>
                        <p>Mejoras a sistema de bóveda para relacionar CFDI...</p>
                      </div>
                    </article>
                    <article class="media event" >
                      <a class="pull-left date" >
                        <p class="month" style="color: #053666"><b>Junio</b></p>
                        <p class="day" style="color: #053666">30</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#" style="color: #053666">Lanzamiento de nueva suite contable.</a>
                        <p>Nuevo producto para contabilidad y facturación electrónica...</p>
                      </div>
                    </article>
                    
                  </div>
 
                                          
                 </div>
              </div>




                            
                                    
                <div class="clearfix"></div>
                <br>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                    </div>
                          

                


                <div class="clearfix"></div>





                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Gigas consumidos totales</h2>
                        
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_pie" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>


                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Gigas consumidos por empresa</h2>
                         <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_bar_horizontal" style="height:370px;"></div>

                      </div>
                    </div>
                  </div>

       
                <div class="clearfix"></div>
                <br />
              

            </div>




            


@endsection

@section('app_js')
    @parent

    <!-- bootstrap-progressbar -->
      <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- Chart.js -->
      <script src="{{ asset('vendors/echarts/dist/echarts.js') }}"></script>
      <script src="{{ asset('vendors/Chart.js/dist/Chart.js') }}"></script>
      <script src="{{ asset('/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.js') }}"></script>
      <script src="{{ asset('/vendors/gauge.js/dist/gauge.js') }}"></script>
      
      <script src="{{ asset('build/js/custom.js') }}"></script>
      <script type="text/javascript">
        
  
        //alert(document.getElementById('iconsapp').value);

        //document.getElementById('diviscons').html(document.getElementById('iconsapp').value);
        $("#diviscons").html(document.getElementById('iconsapp').value);

        
      </script>

      <script type="text/javascript">
        
        function onSelectEmpresa(element){

          $("#pld").addClass('disabled'); 
          $("#cont").addClass('disabled'); 
          $("#nom").addClass('disabled'); 
          $("#bov").addClass('disabled'); 
          $("#not").addClass('disabled'); 
          $("#cc").addClass('disabled'); 
             
             var selected = element.value;

             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

             $.ajax({
                url: 'appbyemp',
                type: 'POST',
                data: {_token: CSRF_TOKEN,selected:selected},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data['appcodes']);
                    data['appcodes'].forEach(function(entry){
                      $("#"+entry).removeClass('disabled');    
                      }
                    );
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    
                }
            });
         }
      </script>

      

@endsection

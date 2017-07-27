@extends('admin.template.main')

@section('app_title')
      Inicio
@endsection



@section('app_css')
    @parent
    <!-- Datatables -->
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet">

    <style type="text/css">
      .disabled {
                 pointer-events: none;
                 cursor: default;
                 opacity: 0.6;
                 color:grey;
              }
      .disabledblocked {
                 pointer-events: none;
                 cursor: default;
                 opacity: 0.3;
                 color:grey;
                -webkit-filter: blur(2px)
              }
      
      .hidden{
            visibility:hidden;
            }
      .contenedor_select {
              overflow-y: auto;
            }
      .iconpld {
            display: inline-block;
            background: url("{{asset('MejoraPLD.png')}}") no-repeat top left;

            }
      .iconpldtest {
            display: inline-block;
            background: url("{{asset('MejoraPLD.png')}}") no-repeat top left;
            -webkit-filter: sepia(100%);

            }
      .iconbov {
            display: inline-block;
            background: url("{{asset('boveda.png')}}") no-repeat top left;

            }
      .iconbovtest {
            display: inline-block;
            background: url("{{asset('boveda.png')}}") no-repeat top left;
            -webkit-filter: sepia(100%)
            }
      .iconfact {
            display: inline-block;
            background: url("{{asset('logo_advans_edited.jpg')}}") no-repeat top left;
            }
      
      .iconfacttest {
            display: inline-block;
            background: url("{{asset('logo_advans_edited.jpg')}}") no-repeat top left;
            -webkit-filter: sepia(100%)
            }
      .icon-accessibility{ 
            background-position: 0 0; width: 100px; height: 60px; 
          } 
      .icon-accessibilityfact{ 
        background-position: 0 0; width: 100px; height: 60px; 
      } 

      .icon-accessibilitybov{ 
            background-position: 0 0; width: 100px; height: 70px; 
          } 

    </style>


@endsection



@section('content')

        <div class="">

        <div class="top_tiles">
              
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">

                  <div class="icon" style="width: 5px; height: 10px; top: 30px;"><i class="fa fa-suitcase" style="color: #053666; font-size: 50px;"></i></div>
                  <div class="count" style="color: #053666;">{{ $appsall }}</div>
                  <p style="color: #053666;"><b>APLICACIONES EN USO</b></p>
                  <a href="{{ URL::to('appsasign') }}"><p style="color: #053666;">{{ $apps }} en producción | {{ $appstest }} en prueba</p></a>
                  <a href="{{ URL::to('appsasign') }}"><p style="color: #053666;">{{ $appsdesact }} bloqueadas</p></a>
                </div>
              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon" style="width: 5px; height: 10px; top: 30px;"><i class="fa fa-database" style="color: #053666; font-size: 50px;"></i></div>
                  <div class="count" style="color: #053666;">{{ $insts }}</div>
                  <p style="color: #053666;"><b>INSTANCIAS CONTRATADAS</b></p>
                  <a href="{{ URL::to('apps') }}"><p style="color: #053666;">{{ $cantinstcreadas -  $cantbdappstest}} en producción | {{ $cantbdappstest }} en prueba</p></a>
                  <a href="{{ URL::to('apps') }}"><p style="color: #053666;">{{ $cantinstcreadas }} total creadas</p></a>

                </div>
              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon" style="width: 5px; height: 10px; top: 30px;"><i class="fa fa-calendar" style="color: #053666; font-size: 50px;"></i></div>
                  <div id="tiempodisp" class="count" style="color: #FFFFFF;">{{ $intervalshow }} </div>
                   <p style="color: #053666;"><b>{{ $medida_tiempo }} </b></p>
                   <p style="color: #053666;">Pago en {{ $fecha_fin }} | Corte en {{ $fecha_caduc }}</p>
                   <p style="color: #053666;">{{ $porc_final }}% de tiempo consumido </p>

                </div>
              </div>

                            
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  
                  <div class="count" style="color: #053666;">{{ $gigas }}
                       <div class="icon" style="width: 5px; height: 10px; top: 30px;"><i class="fa fa-pie-chart" style="color: #053666; font-size: 50px;"></i></div>
                  </div>
                 
                  <p style="color: #053666;"><b>{{ $medidaespdispmay }} CONTRATADOS</b></p>
                  <p style="color: #053666;">{{ $cant_gigas_rest }} {{ $medidaesprest }} disponibles</p>
                  <p style="color: #053666;">{{ $porc_esp_cons }}% de espacio consumido</p>
                </div>
              </div>
            </div>


          

            <div class="contenedor_select col-md-9 col-sm-9 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                          <h2>Acceso a aplicaciones</h2>
                          <div class="clearfix"></div>
                </div>

                <div class="contenedor_select col-md-12 col-sm-12 col-xs-12">
                  
                  <select class="js-example-data-array form-control col-md-9 col-sm-9 col-xs-9" name="select_emp" id="select_emp" onchange="onSelectEmpresa(this)" title="Seleccione razón social">
                      <!--<option value="null">Seleccione una empresa ...</option>-->
                           
                  </select>

                </div>
                <br>
                <br>
                <br>
                <input type="hidden" id="iconsapp" name="iconsapp" value="{{ $appvisible }}">
                <input type="hidden" id="cantinstcreadas" name="cantinstcreadas" value="{{ $cantinstcreadas }}">
                <input type="hidden" id="cantinstcont" name="cantinstcont" value="{{ $apps }}">
                 <input type="hidden" id="inp_colorinterv" name="inp_colorinterv" value="{{ $color_interval }}">
                <div class="contenedor_select col-md-9 col-sm-9 col-xs-12" id="diviscons" style="height:80px;">
   
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
                
                 <br>
                 <br>
                 <br>
              </div>
             </div>


             <div class="col-md-3 col-sm-3 col-xs-12" >
                <div class="x_panel  contenedor_select" >
                <div class="x_title">
                            <h2 style="font-size: 15px">Validar RFC en Art. 69 y 69-B</h2>
                            </br>
                            <p>Actualizado a {{ $fecha_act_69 }}</p>
                            <div class="clearfix"></div>
                  </div>

                       <div class="col-md-12 col-sm-12 col-xs-12" id="art69" style="height:100px;">
                           <div class="input-group" >
                              <input type="text" class="form-control" placeholder="RFC..." id="rfc" name="rfc" style="text-transform: uppercase;" title="Ingrese RFC a validar">
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" onclick="art69cons()" style="background-color: #053666">Consultar</button>
                              </span>

                           </div>
                         <br>

                         <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" name="reporteart" id="reporteart">
                          <meta name="csrf-token" content="{{ csrf_token() }}" />
                    
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal">
                                  <!--<span aria-hidden="true">&times;</span>-->
                                </button>
                              </div>

                              <div class="modal-body" id="modalreporte">

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideModal()">Cerrar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      
                      
                      </div>
                 </div>

                   
              </div>

              <!--<div class="col-md-12 col-sm-12 col-xs-12">

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
                      <label style=" color:#191970">% de tiempo consumido vs fecha de fin {{ $fecha_fin }}</label>

                   </div>

                    <div class="col-md-6">
                        <div class="progress" >
                          <div class="progress-bar" data-transitiongoal=""></div>
                        </div>
                        <label style=" color:#191970;">% de tiempo consumido vs fecha de caducidad {{ $fecha_caduc }}</label>

                    </div>


                </div>
              </div>-->


              <div class="col-md-9 col-sm-9 col-xs-12" >
               <div class="x_panel contenedor_select">
                <div class="x_title">
                          <h2>Otras aplicaciones disponibles</h2>
                          <div class="clearfix"></div>
                </div>

                <div class="contenedor_select col-md-12 col-sm-12 col-xs-12">
                </div>
               
                <input type="hidden" id="iconsappdisp" name="iconsappdisp" value="{{ $appdispvisible }}">
                <div class="contenedor_select col-md-12 col-sm-12 col-xs-12" id="divappdisp" style="height:104px;">
                  
                  
                </div>
                
              </div>
             </div>

             
             <input type="hidden" id="htmlcert" name="htmlcert" value="{{ $htmlcert }}">
             <div class="col-md-3 col-sm-3 col-xs-12" >
              <div class="x_panel contenedor_select">
                      <div class="x_title">
                          <h2>Certificados por vencer</h2>
                          
                          <div class="clearfix"></div>

                          
                      </div>

                       <div class="col-md-12 col-sm-12 col-xs-12" id="certif" style="height:84px;">
                        
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12" id="certifreg" style="height:20px; text-align: left; color: #053666">
                          <a href="{{ URL::to('certificados') }}">{{ $cant_cert }} creados</a>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12" id="certifvenc" style="height:20px; text-align: right; color: #053666">
                          <a href="{{ URL::to('certvencidos') }}">{{ $cant_cert_vencidos }} vencidos</a>
                      </div>

                 </div>
              </div>

                <div class="clearfix"></div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                    </div>
 

                <input type="hidden" name="gigascons" id="gigascons" value="{{ $gigas_cons }}" onchange="fillpiechart(this)" />
                <input type="hidden" name="gigastotal" id="gigastotal" value="{{ $gigas }}"/>
                <input type="hidden" name="gigasemp" id="gigasemp" value="{{ $gigas_empresa }}"/>
                <input type="hidden" name="empcons" id="empcons" value="{{ $empr_cons }}"/>
                <input type="hidden" name="emps" id="emps" value="{{ $emps }}"/>
                <input type="hidden" name="appnames" id="appnames" value="{{ $appnames }}"/>
                <input type="hidden" name="instcont" id="instcont" value="{{ $instcont }}"/>
                <input type="hidden" name="instcreadas" id="instcreadas" value="{{ $instcreadas }}"/>
                <input type="hidden" name="megcons" id="megcons" value="{{ $megcons }}"/>


                <div class="col-md-12 col-sm-12 col-xs-12" id="divnews">
                  <div class="x_panel">
                  <div class="x_title">
                              <h2>Novedades</h2>
                              <div class="clearfix"></div>
                   </div>

                   <input type="hidden" name="news" id="news" value="{{ $noticiasstr }}"/>
                   <div class="x_content contenedor_select">

                   @foreach ($noticias as $n)
                      <article class="media event">
                        <a class="pull-left date" style="width: 80px; " >
                          <p class="month" style="color: #053666"><b>{{ trans('meses.'.DateTime::createFromFormat("Y-m-d", $n->pdate)->format("F")) }}</b></p>
                          <p class="day" style="color: #053666">{{ DateTime::createFromFormat("Y-m-d", $n->pdate)->format("d") }}</p>
                        </a>
                        <div class="media-body">
                          <a class="title" href="{{ $n->nlink }}" style="color: #053666" target='_blank'>{{ $n->tittle }}</a>
                          <p>{{ $n->description }}</p>
                        </div>
                      </article>
                   @endforeach

                     <!-- <article class="media event">
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
                      <article class="media event" >
                        <a class="pull-left date" >
                          <p class="month" style="color: #053666"><b>Dic</b></p>
                          <p class="day" style="color: #053666">30</p>
                        </a>
                        <div class="media-body">
                          <a class="title" href="#" style="color: #053666">Actualización de PLD.</a>
                          <p>Nueva actualización de PLD con mejoras...</p>
                        </div>
                      </article>-->
                      
                      
                    </div>
   
                                            
                   </div>
              </div>


              

              


                 <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Gigas consumidos</h2>
                        
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div id="echart_pie" style="height:350px;"></div>

                      </div>
                    </div>
                  </div>


                  <div class="col-md-4 col-sm-4 col-xs-12 hidden">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Gigas consumidos </h2>
                         <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id="echart_bar_horizontal" style="height:350px;"></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Gigas consumidos por empresa</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id="graph_bar" style="height:350px;"></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12 hidden" >
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
                  </div>-->

                  <div class="col-md-12 col-sm-12 col-xs-12" id="graphapp">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Análisis de instancias por aplicación</h2>
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
      <script src="{{ asset('vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.js') }}"></script>
      <script src="{{ asset('vendors/gauge.js/dist/gauge.js') }}"></script>
      <script src="{{ asset('vendors/raphael/raphael.min.js') }}"></script>
      <script src="{{ asset('vendors/morris.js/morris.min.js') }}"></script>
      <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
      
      <script src="{{ asset('build/js/custom.js') }}"></script>



      <script type="text/javascript">
          

          var dataempr = [];
          var empresas =jQuery.parseJSON(document.getElementById('emps').value);
          
          //console.log(empresas.length);

          if (empresas.length > 0) {
            for (var i = 0; i < empresas.length; i++) {
              var dic = {'id': empresas[i].empr_rfc, 'text': empresas[i].empr_nom};
              dataempr.push(dic);
            }

            $("#select_emp").select2({
                  data: dataempr,
                  allowClear: true
                   
               });

               $("#select_emp_i").select2({
                  data: dataempr,
                  allowClear: true,
                  placeholder: 'Seleccione una empresa'
                   
               });             
          }
          //Asignando valor a div de vigencia de certificado
          var htmlcontent = document.getElementById('htmlcert').value;
          $('#certif').append(htmlcontent);


          //Verificando si existen noticias
          var news =jQuery.parseJSON(document.getElementById('news').value);
          console.log(news.length);


          if (news.length == 0){

            $("#divnews").hide();
          }

          //Verificando si existen instancias creadas
          var cantinstcread = document.getElementById('cantinstcreadas').value;
          var cantinstcont = document.getElementById('cantinstcont').value;
          
          if (cantinstcread == 0 && cantinstcont == 0){
            $("#graphapp").hide();
          }
          else{
            $("#graphapp").show();
          }
          
        </script>

      <script type="text/javascript">
        
        //alert(document.getElementById('iconsapp').value);

        //document.getElementById('diviscons').html(document.getElementById('iconsapp').value);
        $("#diviscons").html(document.getElementById('iconsapp').value);
        $("#divappdisp").html(document.getElementById('iconsappdisp').value);

        
      </script>

      <script type="text/javascript">

      $('#select_emp').trigger('change');
        
        function onSelectEmpresa(element){


          $("#pld").addClass('disabled'); 
          $("#cont").addClass('disabled'); 
          $("#nom").addClass('disabled'); 
          $("#bov").addClass('disabled'); 
          $("#not").addClass('disabled'); 
          $("#cc").addClass('disabled'); 
          $("#fact").addClass('disabled'); 
             
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
                      var link = document.getElementById(entry);  
                      console.log(link);
                      var href = $("#"+entry).data('dir');
                      var newhref = href + element.value ;
                      link.setAttribute("href", '');  
                      link.setAttribute("href", newhref);  
                      }
                    );
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    
                }
            });
         }


         function art69cons(){

              $("#norep").remove();
              var rfc = document.getElementById('rfc').value;
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

              if (rfc != ''){

                $.ajax({
                  url: 'artconsult',
                  type: 'POST',
                  data: {_token: CSRF_TOKEN,rfc:rfc},
                  dataType: 'JSON',
                  success: function (data) {
                    console.log(data);
                    if (data['tienerep'] == false){
                      $('#art69').append(data['reporte']);
                      setTimeout(HideLabel, 5000);
                      
                    }
                    else{
                      $('#modalreporte').append(data['reporte']);
                      document.getElementById('exampleModalLabel').innerHTML = "Reporte de rfc: "+ rfc;
                      showModal();
                    }
                    

                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                      alert("Status: " + textStatus); alert("Error: " + errorThrown);
                      
                  }
              });


              }

         }

         function HideLabel() {
            document.getElementById('rfc').value = '';
            document.getElementById('norep').style.display = "none";
            
          }

          function showModal() {
          $("#reporteart").modal('show');
        }

        function hideModal() {
          document.getElementById('rfc').value = '';
          $("#modalreporte").html("");
          $('#exampleModalLabel').innerHTML = "";
          $("#reporteart").modal('hide');
        }
      </script>

      <script type="text/javascript">


      function checktime() {
        var divtiempodisp = document.getElementById('tiempodisp');
        var inp_colorinterv = document.getElementById('inp_colorinterv').value;
        divtiempodisp.style.color = inp_colorinterv;

      }


      $('#gigascons').trigger('change');
        function fillpiechart(gigascons) {

          checktime();        

          var gig_cons = gigascons.value;
          var gig_disp = document.getElementById('gigastotal').value - gig_cons;
          var gig_emp = document.getElementById('gigasemp').value;
          var emp_cons = document.getElementById('empcons').value;
          var appnames = document.getElementById('appnames').value;
          var instcont = document.getElementById('instcont').value;
          var instcreadas = document.getElementById('instcreadas').value;
          var megcons = document.getElementById('megcons').value;
          
          var arraybar = [];
          var arraymainb = [];

           for (var i = 0; i < jQuery.parseJSON(emp_cons).length; i++) {
            var dic = {'empresa': jQuery.parseJSON(emp_cons)[i], 'gigas':jQuery.parseJSON(gig_emp)[i]};

             arraybar.push(dic);
             
           }

           if (arraybar.length == 0){
            var dic = {'empresa': '', 'gigas':0};
             arraybar.push(dic);

           }


                      var theme = {
              color: [
                '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
                '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
              ],

              title: {
                itemGap: 8,
                textStyle: {
                  fontWeight: 'normal',
                  color: '#408829'
                }
              },

              dataRange: {
                color: ['#1f610a', '#97b58d']
              },

              toolbox: {
                color: ['#408829', '#408829', '#408829', '#408829']
              },

              tooltip: {
                backgroundColor: 'rgba(0,0,0,0.5)',
                axisPointer: {
                  type: 'line',
                  lineStyle: {
                    color: '#408829',
                    type: 'dashed'
                  },
                  crossStyle: {
                    color: '#408829'
                  },
                  shadowStyle: {
                    color: 'rgba(200,200,200,0.3)'
                  }
                }
              },

              dataZoom: {
                dataBackgroundColor: '#eee',
                fillerColor: 'rgba(64,136,41,0.2)',
                handleColor: '#408829'
              },
              grid: {
                borderWidth: 0
              },

              categoryAxis: {
                axisLine: {
                  lineStyle: {
                    color: '#408829'
                  }
                },
                splitLine: {
                  lineStyle: {
                    color: ['#eee']
                  }
                }
              },

              valueAxis: {
                axisLine: {
                  lineStyle: {
                    color: '#408829'
                  }
                },
                splitArea: {
                  show: true,
                  areaStyle: {
                    color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                  }
                },
                splitLine: {
                  lineStyle: {
                    color: ['#eee']
                  }
                }
              },
              timeline: {
                lineStyle: {
                  color: '#408829'
                },
                controlStyle: {
                  normal: {color: '#408829'},
                  emphasis: {color: '#408829'}
                }
              },

              k: {
                itemStyle: {
                  normal: {
                    color: '#68a54a',
                    color0: '#a9cba2',
                    lineStyle: {
                      width: 1,
                      color: '#408829',
                      color0: '#86b379'
                    }
                  }
                }
              },
              map: {
                itemStyle: {
                  normal: {
                    areaStyle: {
                      color: '#ddd'
                    },
                    label: {
                      textStyle: {
                        color: '#c12e34'
                      }
                    }
                  },
                  emphasis: {
                    areaStyle: {
                      color: '#99d2dd'
                    },
                    label: {
                      textStyle: {
                        color: '#c12e34'
                      }
                    }
                  }
                }
              },
              force: {
                itemStyle: {
                  normal: {
                    linkStyle: {
                      strokeColor: '#408829'
                    }
                  }
                }
              },
              chord: {
                padding: 4,
                itemStyle: {
                  normal: {
                    lineStyle: {
                      width: 1,
                      color: 'rgba(128, 128, 128, 0.5)'
                    },
                    chordStyle: {
                      lineStyle: {
                        width: 1,
                        color: 'rgba(128, 128, 128, 0.5)'
                      }
                    }
                  },
                  emphasis: {
                    lineStyle: {
                      width: 1,
                      color: 'rgba(128, 128, 128, 0.5)'
                    },
                    chordStyle: {
                      lineStyle: {
                        width: 1,
                        color: 'rgba(128, 128, 128, 0.5)'
                      }
                    }
                  }
                }
              },
              
              textStyle: {
                fontFamily: 'Arial, Verdana, sans-serif'
              }
            };


              console.log(jQuery.parseJSON(appnames));
              console.log(jQuery.parseJSON(instcont));
              console.log(jQuery.parseJSON(instcreadas));

                  //MAINB
      if ($('#mainb').length ){
        
          var echartBar = echarts.init(document.getElementById('mainb'), theme);

          echartBar.setOption({
          title: {
            text: '',
            subtext: ''
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            data: ['Instancias contratadas', 'Instancias creadas']
          },
          toolbox: {
            show: false
          },
          calculable: false,
          xAxis: [{
            type: 'category',
            data: jQuery.parseJSON(appnames)
          }],
          yAxis: [{
            type: 'value',
            boundaryGap: [0, 1]
          }],
          series: [{
            name: 'Instancias contratadas',
            type: 'bar',
            data: jQuery.parseJSON(instcont),
            markPoint: {
            data: [{
              type: 'max',
              name: 'max'
            }, {
              type: 'min',
              name: 'min'
            }]
            }
          }, {
            name: 'Instancias creadas',
            type: 'bar',
            data: jQuery.parseJSON(instcreadas),
            markPoint: {
            data: [{
              type: 'max',
              name: 'max'
            }, {
              type: 'min',
              name: 'min'
            }]
            }
          }]
          });

      }



          if ($('#echart_pie').length ){  
        
            var echartPie = echarts.init(document.getElementById('echart_pie'), theme);

            var dataStyle = {
            normal: {
              color: 'rgba(0,128,128,1.0)',
              label: {
              show: true
              },
              labelLine: {
              show: false
              }
            }
            };

            var dataStyle1 = {
            normal: {
              color: 'rgba(5, 54, 102, 1)',
              label: {
              show: true
              },
              labelLine: {
              show: false
              }
            }
            };

            echartPie.setOption({
            title: {
              text: '',
              subtext: '',
              sublink: 'http://e.weibo.com/1341556070/AhQXtjbqh',
              x: 'center',
              y: 'center',
              itemGap: 20,
              textStyle: {
              color: 'rgba(30,144,255,0)',
              fontFamily: '',
              fontSize: 35,
              fontWeight: 'bolder'
              }
            },
            tooltip: {
              trigger: 'item',
              formatter: "{a} <br/>{b} : {c}"
            },
            /*legend: {
              x: 'center',
              y: 'bottom',
              data: ['Disponibles', 'Consumidos']
            },*/
            toolbox: {
              show: true,
              feature: {
              
              restore: {
                show: true,
                title: "Restore"
              },
              saveAsImage: {
                show: true,
                title: "Save Image"
              }
              }
            },
            calculable: true,
            series: [{
              name: 'Gigas',
              type: 'pie',
              radius: '55%',
              center: ['50%', '48%'],
              data: [{
              value: gig_cons,
              name: 'Consumidos',
              itemStyle: dataStyle1,
              }, {
              value: gig_disp,
              name: 'Disponibles',
              itemStyle: dataStyle,
              }]
            }]
            });

            if ($('#echart_bar_horizontal').length ){ 

        
              var echartBar = echarts.init(document.getElementById('echart_bar_horizontal'), theme);

              var dataStyle = {
              normal: {
                color: 'rgba(121, 13, 78,0.7)',
                label: {
                show: false
                },
                labelLine: {
                show: false
                }
              }
              };

              
              echartBar.setOption({
              title: {
                text: '',
                subtext: ''
              },
              tooltip: {
                trigger: 'axis'
              },
              legend: {
                x: 'center',
                y: 'top',
                data: jQuery.parseJSON(emp_cons) 
              },
              toolbox: {
                show: true,
                feature: {
                saveAsImage: {
                  show: true,
                  title: "Save Image"
                }
                }
              },
              calculable: true,
              xAxis: [{
                type: 'value',
                boundaryGap: [0, 0.10]
              }],
              yAxis: [{
                type: 'category',
                data: jQuery.parseJSON(emp_cons)
              }],
              series: [{
                name: 'Gigas consumidos',
                type: 'bar',
                data: jQuery.parseJSON(gig_emp),
                itemStyle: dataStyle
              }]
              });

      } 


      //if ($('#graph_bar').length){ 
      
              /*data: [
                  {device: 'iPhone 4', geekbench: 380},
                  {device: 'iPhone 4S', geekbench: 655},
                  {device: 'iPhone 3GS', geekbench: 275}
                  ],*/


              Morris.Bar({
                element: 'graph_bar',
                data: arraybar,
                xkey: 'empresa',
                ykeys: ['gigas'],
                labels: ['Cantidad de gigas'],
                barRatio: 0.4,
                barColors: ['#053666', '#053666', '#053666', '#053666'],
                xLabelAngle: 35,
                hideHover: 'auto',
                resize: true
              });
              0,128,128,1.0
      //} 

            

            var placeHolderStyle = {
            normal: {
              color: 'rgba(0,0,0,0)',
              label: {
              show: false
              },
              labelLine: {
              show: false
              }
            },
            emphasis: {
              color: 'rgba(0,0,0,0)'
            }
            };


            if ($('#echart_mini_pie').length ){ 
        
        var echartMiniPie = echarts.init(document.getElementById('echart_mini_pie'), theme);

        var dataStylee = {
        normal: {
          color: 'rgba(0,128,128,1.0)',
          label: {
          show: false
          },
          labelLine: {
          show: false
          }
        }
        };

        var dataStylee1 = {
        normal: {
           color: 'rgba(0,128,128,0.6)',
          label: {
          show: false
          },
          labelLine: {
          show: false
          }
        }
        };

        var placeHolderStylee = {
        normal: {
          color: 'rgba(0,0,0,0)',
          label: {
          show: false
          },
          labelLine: {
          show: false
          }
        },
        emphasis: {
          color: 'rgba(192,192,192,192)'
        }
        };

        echartMiniPie .setOption({
        title: {
          text: '',
          subtext: '',
          sublink: 'http://e.weibo.com/1341556070/AhQXtjbqh',
          x: 'center',
          y: 'center',
          itemGap: 20,
          textStyle: {
          color: 'rgba(30,144,255,0.8)',
          fontFamily: '微软雅黑',
          fontSize: 35,
          fontWeight: 'bolder'
          }
        },
        tooltip: {
          show: true,
          formatter: "{a} <br/>{b} : {c}"
        },
        legend: {
          orient: 'vertical',
          x: 170,
          y: 45,
          itemGap: 12,
          data: ['Semanas', 'Días'],
        },
        toolbox: {
          show: true,
          feature: {
          mark: {
            show: true
          },
          dataView: {
            show: true,
            title: "Vista de tabla",
            lang: [
            "Vista de tabla",
            "Cerrar",
            "Refrescar",
            ],
            readOnly: false
          },
          restore: {
            show: true,
            title: "Restore"
          },
          saveAsImage: {
            show: true,
            title: "Save Image"
          }
          }
        },
        series: [{
          name: 'Semanas',
          type: 'pie',
          clockWise: false,
          radius: [105, 130],
          itemStyle: dataStylee,
          data: [{
          value: 5,
          name: 'Consumido'
          }, {
          value: 10,
          name: 'Disponible',
          itemStyle: placeHolderStylee
          }]
        }, {
          name: 'Días',
          type: 'pie',
          clockWise: false,
          radius: [80, 105],
          itemStyle: dataStylee1,
          data: [{
          value: 35,
          name: 'Consumido'
          }, {
          value: 70,
          name: 'Disponible',
          itemStyle: placeHolderStylee
          }]
        }]
        });

      } 

          } 
            }
      </script>

      

@endsection

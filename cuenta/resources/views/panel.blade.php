@extends('admin.template.main')


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
                 opacity: 0.4;
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

      .iconcont {
            display: inline-block;
            background: url("{{asset('contabilidad.png')}}") no-repeat top left;

            }
      .iconconttest {
            display: inline-block;
            background: url("{{asset('contabilidad.png')}}") no-repeat top left;
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

      .icon-accessibilitycont{ 
            background-position: 0 0; width: 100px; height: 60px; 
          } 

    </style>


@endsection

@section('content')

        <div class="">

        <div class="top_tiles">



                      

                      <div class="modal fade ini" id="passmodalini" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                        <div class="modal-dialog ini" role="document" style=" width:60%">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Cambio de contraseña: {{ Auth::user()->name}}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <!--<span aria-hidden="true">&times;</span>-->
                              </button>
                            </div>
                            <div class="modal-body ini">
                              <form>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="input-group col-md-4 col-sm-4 col-xs-12">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i>
                                        </span>
                                        <input placeholder="Nueva Contraseña" type="password" class="form-control " id="passwordini" name="passwordini">
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                       
                                    </div>

                                    <div class="input-group col-md-3 col-sm-3 col-xs-12">
                                      <button type="button" onclick="changePassIni({{ Auth::user()->id }});" class="btn btn-primary" style=" background-color:#062c51; ">Guardar</button>
                                    </div>
                                </div>
                              </form>
                           </div>
                            <div class="modal-footer">
                            <div  class="form-group col-md-12 col-sm-12 col-xs-12">
                             <div id="result_failure_pass" class="col-md-9 col-sm-9 col-xs-12" style="color: red;text-align: left; overflow-x: auto; font-size: 13px" >
                             </div>
                             <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <!--<button type="button" onclick="cleanmodalPass();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>-->
                                
                             </div>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
















              
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
                  <p style="color: #053666;"><b>SOLUCIONES CONTRATADAS</b></p>
                  <a href="{{ URL::to('apps') }}"><p style="color: #053666;">{{ $cantinstcreadas }} creadas</p></a>
                  <a href="{{ URL::to('apps') }}"><p style="color: #053666;">{{ $cantinstcreadas -  $cantbdappstest}} en producción | {{ $cantbdappstest }} en prueba</p></a>

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
                          <h2>Acceso a soluciones</h2>
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
                 <input type="hidden" id="inp_numcta" name="inp_numcta" value="{{ $num_cta }}">
                 <input type="hidden" id="inp_user" name="inp_user" value="{{  Auth::user()->id }}">
                 <input type="hidden" id="inpasschange" name="inpasschange" value="{{ $pass_change }}">
                <div class="contenedor_select col-md-9 col-sm-9 col-xs-12" id="diviscons" style="height:80px;">
   
                </div>
                
                 <br>
                 <br>
                 <br>
              </div>
             </div>


             <div class="col-md-3 col-sm-3 col-xs-12" >
                <div class="x_panel  contenedor_select" >
                  <div class="x_title">
                      <h2 class="col-md-12 col-sm-12 col-xs-12" style="font-size: 15px">Validar RFC en Art. 69 y 69-B</h2>
                      </br>
                      <p class="col-md-12 col-sm-12 col-xs-12">Actualizado a {{ $fecha_act_69 }}</p>
                      
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
                      
                    </div>
                  </div>
              </div>

                  <div class="col-md-12 col-sm-12 col-xs-12" id="graphapp">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Análisis de soluciones por aplicación</h2>
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

          $(document).ready(function() {
            $(window).load(function() {
                var changepass = document.getElementById('inpasschange').value;
                if (changepass == 0)
                {
                  showModalIni();
                }
            });
        });


          //Métodos de cambio de contraseña
          function showModalIni() {

          $("#passmodalini").modal('show');
          
        }

    function hideModalIni() {
          $("#passmodalini").modal('hide');
        }


    function changePassIni(user){

           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var password = document.getElementById('passwordini').value;

           if(password){
              console.log(password);
              console.log(user);
              $.ajax({
                url: '/cambcont',
                type: 'POST',
                data: {_token: CSRF_TOKEN,password:password,user:user},
                dataType: 'JSON',

                success: function (data) {

                  hideModalIni();
                  
               },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    console.log(textStatus);
                    console.log(errorThrown);
                    $("#result_failure_pass").html('<p>Contraseña inválida, debe contener al menos una mayúscula, una minúscula, un número y un caracter especial</p>');

                }
            });
            }
            else{
              $("#result_failure_pass").html('<p>La contraseña es obligatoria</p>');
              
           }

           document.getElementById("passwordini").value = "";

   }

//Fin de métodos de cambio de contraseña

          var dataempr = [];
          var empresas =jQuery.parseJSON(document.getElementById('emps').value);
          
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
          

        
        $("#diviscons").html(document.getElementById('iconsapp').value);
        $("#divappdisp").html(document.getElementById('iconsappdisp').value);
        

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
                      var numcta = document.getElementById('inp_numcta').value;
                      var userid = document.getElementById('inp_user').value;
                      var href = $("#"+entry).data('dir');
                      //var newhref = href + '/loginservice/' + numcta + '_' + element.value + '_' + entry + '/' + userid;
                      var newhref = '/redirectapp/' + numcta + '/' + element.value + '/' + entry;
                      link.setAttribute("href", '');  
                      link.setAttribute("href", newhref);  
                      }
                    );
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
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
            data: ['Soluciones contratadas', 'Soluciones creadas']
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
            name: 'Soluciones contratadas',
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
            name: 'Soluciones creadas',
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
      }
      </script>

@endsection

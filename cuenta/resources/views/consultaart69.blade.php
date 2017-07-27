
@extends('admin.template.main')

@section('app_title')
      Consulta de artículo 69
@endsection 

@section('app_css')
    @parent
    <!-- Switchery -->
    <link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.css') }}" rel="stylesheet">
    <!-- File Input -->
    <link href="{{ asset('vendors/bootstrap-fileinput-master/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- Chosen -->
    <link href="{{ asset('vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/cropper/dist/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">


    <style>
    .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
    .kv-reqd {
        color: red;
        font-family: monospace;
        font-weight: normal;
    }
    .hidden{
            visibility:hidden;
            }
	
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Consultar artículo 69 y 69-B</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>

                </ul>
                <div class="clearfix"></div>
              </div>
                  @if (Session::has('message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ Session::get('message') }}</strong>
                  </div>
                  @endif
              <div class="x_content">

                <!--<form class="form-horizontal form-label-left input_mask">-->
                <form id="consult69form" class="form-horizontal form-label-left" novalidate enctype="multipart/form-data">

                      {{ csrf_field() }}

                   
                    <table border="0" class="col-md-12 col-sm-12 col-xs-12">
                    <tr>
                   
                    <td>

                    <div class="item form-group col-md-12 col-sm-12 col-xs-12">
		                    <label>Opciones para filtro:</label>
			                        <div class="radio" title="Búsqueda por RFC">
			                            <label>
			                              <input type="radio" id="filtrorfc"  checked name="iCheckfiltro" onclick="rfcfiltro(this);" value="1"> Por RFC
			                            </label>
			                         </div>
			                         <div class="radio" title="Búsqueda por otras opciones de filtro">
			                            <label>
			                              <input type="radio" id="filtrootro" name="iCheckfiltro" onclick="rfcfiltro(this);" value="2"> Otros filtros
			                            </label>
			                         </div>
			                         <div class="ln_solid"></div>
			        </div>


			        <div id="div_rfc" class="item form-group col-md-6 col-sm-6 col-xs-12">
			        <div  class="item form-group {{ $errors->has('empr_rfc') ? 'bad' : '' }}">
                        
                        
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="rfc_69" class="form-control has-feedback-left" name="rfc_60" placeholder="RFC" type="text" data-validate-words="1" value="{{ old('empr_rfc') }}" autocomplete="off" data-inputmask="'mask' : '*************'" style="text-transform: uppercase;" title="RFC a buscar">
                              <span class="fa fa-star form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
	                            <span style="float: left; color: red;" id="span_empr_rfc" {{$errors->has('empr_rfc') ? '' : 'hidden'}}>
	                                {{ $errors->first('empr_rfc') }}
	                            </span>
                        	</div>
                          </div>
			        	
			        </div>

			        <div id="div_otros_filtros" class="item form-group col-md-6 col-sm-6 col-xs-12 hidden">

                          <div class="item form-group">
                          	<div class="col-md-10 col-sm-10 col-xs-12">
                              <input id="nombre_69" class="form-control has-feedback-left" name="nombre_69" placeholder="Nombre y apellidos" type="text" autocomplete="off" title="Nombre y apellidos">
                              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>
                          	
                          </div>

                          <div class="item form-group">
                          	<div class="col-md-10 col-sm-10 col-xs-12">
                              <input id="oficio_69" class="form-control has-feedback-left" name="oficio_69" placeholder="Número de oficio" type="text" autocomplete="off" title="Número de oficio">
                              <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                           </div>

                           <div class="item form-group">
                           		<div class="col-md-10 col-sm-10 col-xs-12">
	                              <select id="estado_69" name="estado_69[]" class="js-example-data-array form-control" multiple="multiple" title="Estado o tipo a buscar" style="width: 100%">
	                                    <option value="presunto">Presunto</option>
	                                    <option value="definitivo">Definitivo</option>
	                                    <option value="desvirtuado">Desvirtuado</option>
	                              </select>
                              </div>
                           </div>
                            

			        </div>
			        <div id="div_sat" class="item form-group col-md-3 col-sm-3 col-xs-12 hidden">

			        	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
                            <label>
                              <input type="checkbox" class="js-switch" onchange="showSatFechas(this)" id="switchsat" />Por Fecha del SAT
                            </label>
                          </div>

                          <div class="item form-group hidden" id="div_satopc">
                          	<div class="col-md-12 col-sm-12 col-xs-12" style="margin-left: 20px">
				                        <div class="radio" title="Búsqueda por RFC">
				                            <label>
				                              <input type="radio" checked name="iChecksat" onclick="satIntFechas(this);" value="1" id="checksat1"> Fecha específica
				                            </label>
				                         </div>
				                         <div class="radio" title="Búsqueda por otras opciones de filtro">
				                            <label>
				                              <input type="radio" name="iChecksat" onclick="satIntFechas(this);" value="2" id="checksat2"> Rango de fechas
				                            </label>
				                         </div>
			        		</div> 
                          </div>
							

                          <div id="div_fecha_esp_sat" class="row item form-group hidden">
                          	<div class="item form-group">
                          		<input type="date" id="inp_fecha_esp_sat" name="inp_fecha_esp_sat" title="Fecha de publicación en el SAT" style="margin-left: 25px">
                          	</div>
                          
                      	</div>

                          <div id="div_int_fecha_sat" class="item form-group hidden">
                          	<div class="item form-group">
	                          	<input type="date" id="inp_fecha_ini_sat" name="inp_fecha_ini_sat" title="Fecha de inicio de intervalo" style="margin-left: 25px">
	                          	
	                          </div>
	                          <div class="item form-group">
	                          	<input type="date" id="inp_fecha_fin_sat" name="inp_fecha_fin_sat" title="Fecha de fin de intervalo" style="margin-left: 25px">
	                          	
	                          </div>
                          	
                          </div>
			        	

			        </div>


			        <div id="div_dof" class="item form-group col-md-3 col-sm-3 col-xs-12 hidden">

			        	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
                            <label>
                              <input type="checkbox" class="js-switch" id="switchdof" onchange="showDofFechas(this)"/>Por fecha del DOF
                            </label>
                          </div>

                          <div class="item form-group hidden" id="div_dofopc">
                          	<div class="col-md-12 col-sm-12 col-xs-12">
				                        <div class="radio" title="Búsqueda por RFC">
				                            <label>
				                              <input type="radio" checked name="iCheckdof" onclick="dofIntFechas(this);" value="1" id="checkdof1"> Fecha específica
				                            </label>
				                         </div>
				                         <div class="radio" title="Búsqueda por otras opciones de filtro">
				                            <label>
				                              <input type="radio" name="iCheckdof" onclick="dofIntFechas(this);" value="2" id="checkdof2"> Rango de fechas
				                            </label>
				                         </div>
			        		</div> 
                          </div>
							

                          <div id="div_fecha_esp_dof" class="row item form-group hidden">
                          	<input type="date" id="inp_fecha_esp_dof" name="inp_fecha_esp_dof" title="Fecha de publicación en el DOF" style="margin-left: 25px">
                      	</div>

                      


                          <div id="div_int_fecha_dof" class="item form-group hidden">
	                          <div class="item form-group">
	                          	<input type="date" id="inp_fecha_ini_dof" name="inp_fecha_ini_dof" title="Fecha de inicio de intervalo" style="margin-left: 25px">
	                          </div>

	                          <div class="item form-group">
	                          	<input type="date" id="inp_fecha_fin_dof" name="inp_fecha_fin_dof" title="Fecha de fin de intervalo" style="margin-left: 25px">
	                          </div>
                          </div>
			        </div>

                          
                         
                      <div class="ln_solid"></div>
                      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                        <button class="btn btn-primary" type="button" onclick="requestConsult();" style="color:#FFFFFF; background-color:#2d5986 ">Buscar</button>
                        </div>
                      </div>

                    </td>

                   
                    </tr>
                    </table>



                    <div class="col-md-12 col-sm-12 col-xs-12">
                        </br>
                        </br>
                    </div>

                    


                      

                        <div class="x_content">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Resultado</a>
                            
                            </li>
                          </ul>

                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
		                        <tr style="color:#FFFFFF; background-color:#2d5986 ">
		                          <th>RFC</th>
		                          <th>Razón social</th>
		                          <th>Tipo</th>
                              <th>Oficio</th>
		                          <th>Fecha SAT</th>
		                          <th>Fecha DOF</th>
		                          <th>URL oficio</th>
		                          <th>URL anexo</th>
		                        </tr>
		                      </thead>
		                       <tbody>
		                       </tbody>
                            	
                            </table>
                                


                            </div>


                          </div>
                        </div>
                    </div>

                      

                    </form>

              </div>
            </div>
          </div>
    </div>
</div>
@endsection

@section('app_js')
    @parent


    <!-- validator -->
    <script src="{{ asset('vendors/validator/control.validator.js') }}"></script>

    <!-- Date Time -->
    <script type="text/javascript" src="{{ asset('vendors/datetime/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('vendors/datetime/js/locales/bootstrap-datetimepicker.es.js') }}" charset="UTF-8"></script>

    <!-- Switchery -->
    <script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>

    <!-- File Input -->
    <script src="{{ asset('vendors/bootstrap-fileinput-master/js/fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>

    <!-- Chosen -->
    <script src="{{ asset('vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

    <script src="{{ asset('vendors/moment/min/moment.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript" charset="utf-8"></script>

    <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.js') }}"></script>



    <script type="text/javascript">

    	$("#estado_69").select2({
                  allowClear: true,
                  placeholder: 'Tipo'
                  
               });

		function rfcfiltro(filtroelem){

			if (filtroelem.value == 1){
				$("#div_rfc").removeClass('hidden'); 
				$("#div_otros_filtros").addClass('hidden'); 
				$("#div_sat").addClass('hidden'); 
				$("#div_dof").addClass('hidden');
			}
			else
			{	
				$("#div_rfc").addClass('hidden'); 
				$("#div_otros_filtros").removeClass('hidden');
				$("#div_sat").removeClass('hidden'); 
				$("#div_dof").removeClass('hidden');

			}
			

		}
		//SAT
		function showSatFechas(element){

			var checksat1 = document.getElementById('checksat1');
			var checksat2 = document.getElementById('checksat2');

			if (checksat1.checked == true)
				satIntFechas(checksat1);
			else
				satIntFechas(checksat2);

			if (element.checked == true){
				$("#div_satopc").removeClass('hidden'); 
			}
			else{
				$("#div_satopc").addClass('hidden'); 
				$("#div_fecha_esp_sat").addClass('hidden'); 
				$("#div_int_fecha_sat").addClass('hidden');

			}
		}

		function satIntFechas(element){
			
			if (element.value == 1){
				$("#div_fecha_esp_sat").removeClass('hidden'); 
				$("#div_int_fecha_sat").addClass('hidden'); 
			}
			else{
				$("#div_fecha_esp_sat").addClass('hidden'); 
				$("#div_int_fecha_sat").removeClass('hidden');
			}
		}

		//DOF
		function showDofFechas(element){

			var checkdof1 = document.getElementById('checkdof1');
			var checkdof2 = document.getElementById('checkdof2');
			if (checkdof1.checked == true)
				dofIntFechas(checkdof1);
			else
				dofIntFechas(checkdof2);

			if (element.checked == true){
				$("#div_dofopc").removeClass('hidden'); 
			}
			else{
				$("#div_dofopc").addClass('hidden'); 
				$("#div_fecha_esp_dof").addClass('hidden'); 
				$("#div_int_fecha_dof").addClass('hidden');

			}
		}

		function dofIntFechas(element){
			
			if (element.value == 1){
				$("#div_fecha_esp_dof").removeClass('hidden'); 
				$("#div_int_fecha_dof").addClass('hidden'); 
			}
			else{
				$("#div_fecha_esp_dof").addClass('hidden'); 
				$("#div_int_fecha_dof").removeClass('hidden');
			}
		}


    	function init_daterangepicker_reservation() {
	      
			if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
			console.log('init_daterangepicker_reservation');
		 
			$('#intfsat').daterangepicker(null, function(start, end, label) {
			  console.log(start.toISOString(), end.toISOString(), label);
			});
			$('#intfdof').daterangepicker(null, function(start, end, label) {
			  console.log(start.toISOString(), end.toISOString(), label);
			});

			$('#reservation-time').daterangepicker({
			  timePicker: true,
			  timePickerIncrement: 30,
			  locale: {
				format: 'MM/DD/YYYY h:mm A'
			  }
			});
	
		}

		function init_daterangepicker_single_call() {
	      
			if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
			console.log('init_daterangepicker_single_call');
		   
			$('#single_cal1').daterangepicker({
			  singleDatePicker: true,
			  singleClasses: "picker_1"
			}, function(start, end, label) {
			  console.log(start.toISOString(), end.toISOString(), label);
			});
			$('#single_cal2').daterangepicker({
			  singleDatePicker: true,
			  singleClasses: "picker_2"
			}, function(start, end, label) {
			  console.log(start.toISOString(), end.toISOString(), label);
			});
			$('#fechasat').daterangepicker({
			  singleDatePicker: true,
			  singleClasses: "picker_3"
			}, function(start, end, label) {
			  console.log(start.toISOString(), end.toISOString(), label);
			});
			$('#fechadof').daterangepicker({
			  singleDatePicker: true,
			  singleClasses: "picker_3"
			}, function(start, end, label) {
			  console.log(start.toISOString(), end.toISOString(), label);
			});
			$('#single_cal4').daterangepicker({
			  singleDatePicker: true,
			  singleClasses: "picker_4"
			}, function(start, end, label) {
			  console.log(start.toISOString(), end.toISOString(), label);
			});
  
  
		}

		$('input[type="radio"]').on('click change', function(e) {
		    console.log(e.type);
		});

		function newsearch(){
			var table = document.getElementById("datatable-responsive");
   			var rowCount = table.rows.length;

			while(table.rows.length > 1) {

			  table.deleteRow(1);
			}


		}


		function requestConsult(){

			newsearch();

			var by_rfc = 1;
      var filtrorfc = document.getElementById('filtrorfc');
      var rfc_value = document.getElementById('rfc_69').value;
      var nombre_value = document.getElementById('nombre_69').value;
      var oficio_value = document.getElementById('oficio_69').value;
      var fecha_esp_sat = document.getElementById('inp_fecha_esp_sat').value;
      var fecha_esp_dof = document.getElementById('inp_fecha_esp_dof').value;
      var fecha_ini_sat = document.getElementById('inp_fecha_ini_sat').value;
      var fecha_fin_sat = document.getElementById('inp_fecha_fin_sat').value;
      var fecha_ini_dof = document.getElementById('inp_fecha_ini_dof').value;
      var fecha_fin_dof = document.getElementById('inp_fecha_fin_dof').value;

      var estado_value = [];
      var select_estado = document.getElementById('estado_69');
      for (i = 0; i < select_estado.length; i++)
      {
        if (select_estado.options[i].selected) estado_value.push(select_estado.options[i].value);
      }
      //console.log(estado_value);

      var by_sat = 2;
      var by_sat_specific = 2;
      if (document.getElementById('switchsat').checked == true){
        by_sat =  1;
        if (document.getElementById('checksat1').checked == true){
          by_sat_specific = 1;
          if (fecha_esp_sat == '')
          { 
            alert("Debe especificar una fecha de publicación en el SAT");
            throw new Error("Debe especificar una fecha de publicación en el SAT");
          }
        }
        else
        {
          if (fecha_ini_sat == '' || fecha_fin_sat == '')
          { 
            alert("Debe especificar ambos intervalos de fecha para publicación en el SAT");
            throw new Error("Debe especificar ambos intervalos de fecha para publicación en el SAT");
          }

        }

      }


      var by_dof = 2;
      var by_dof_specific = 2;
      if (document.getElementById('switchdof').checked == true){
        by_dof =  1;
        if (document.getElementById('checkdof1').checked == true){
          by_dof_specific = 1;
           if (fecha_esp_dof == '')
          { 
            alert("Debe especificar una fecha de publicación en el DOF");
            throw new Error("Debe especificar una fecha de publicación en el DOF");
          }
        }
        else
        {
          if (fecha_ini_dof == '' || fecha_fin_dof == '')
          { 
            alert("Debe especificar ambos intervalos de fecha para  publicación en el DOF");
            throw new Error("Debe especificar ambos intervalos de fecha para publicación en el DOF");
          }

        }
      }
      

      if (filtrorfc.checked == false){
        by_rfc = 2;
        if (nombre_value == '' && oficio_value == '' && estado_value.length == 0 && by_sat == 2 && by_dof == 2)
        {
            alert("Debe especificar al menos un filtro");
            throw new Error("Debe especificar al menos un filtro");
        }
      }
      else if(rfc_value == ''){
        alert("Debe especificar un RFC");
        throw new Error("Debe especificar un RFC");
      }
			
             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

             $.ajax({
                url: 'request69consult',
                type: 'POST',
                data: {_token: CSRF_TOKEN,by_rfc:by_rfc,by_sat:by_sat,by_sat_specific:by_sat_specific,by_dof:by_dof,by_dof_specific:by_dof_specific,rfc_value:rfc_value,nombre_value:nombre_value,oficio_value:oficio_value,estado_value:estado_value,fecha_esp_sat:fecha_esp_sat,fecha_esp_dof:fecha_esp_dof,fecha_ini_sat:fecha_ini_sat,fecha_fin_sat:fecha_fin_sat,fecha_ini_dof:fecha_ini_dof,fecha_fin_dof:fecha_fin_dof},
                dataType: 'JSON',
                success: function (response) {
                    if (response['status'] == 'Success'){
                      var dataTablevalues = []; 
                      var table_counter = 0; 
                      response['registros69'].forEach(function(item){
                            dataTablevalues.push([item.rfc,item.contribuyente,item.tipo,item.oficio,item.fecha_sat,item.fecha_dof,"<a target='_blank' href='"+item.url_oficio+"'>"+item.url_oficio+"</a>","<a target='_blank' href='"+item.url_anexo+"'>"+item.url_anexo+"</a>"]);
                                                table_counter ++;
                                            });


                      $('#datatable-responsive').dataTable().fnDestroy();
                      dtobj = $('#datatable-responsive').DataTable( {
                          data: dataTablevalues,
                      });
                      
                      /*
                      var registros69 = response['registros69'];
      	        			var table = document.getElementById("datatable-responsive");

      	        			if (registros69.length > 0) {
      				            for (var i = 0; i < registros69.length; i++) {

      				              var row = table.insertRow(i+1);
      				              
      				              var cell0 = row.insertCell(0);
      				              cell0.innerHTML = registros69[i].rfc;

      				              var cell1 = row.insertCell(1);
      				              cell1.innerHTML = registros69[i].contribuyente;

      				              var cell2 = row.insertCell(2);
      				              cell2.innerHTML = registros69[i].tipo;
      				             
      				              var cell3 = row.insertCell(3);
      				              cell3.innerHTML = registros69[i].oficio;

      				              var cell4 = row.insertCell(4);
      				              cell4.innerHTML = registros69[i].fecha_sat;

                            var cell5 = row.insertCell(5);
                            cell5.innerHTML = registros69[i].fecha_dof;

      				              var cell6 = row.insertCell(6);
      				              cell6.innerHTML = registros69[i].url_oficio;

      				              var cell7 = row.insertCell(7);
      				              cell7.innerHTML = registros69[i].url_anexo;

      				            }
      				        }*/
	        		     }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("XMLHttpRequest: " + XMLHttpRequest); alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    
                }
            });
         }
    </script>


    


@endsection   
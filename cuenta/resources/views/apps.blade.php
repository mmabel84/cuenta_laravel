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
                    <h2>Lista de soluciones</h2>
                    <div class="clearfix"></div>
                  </div>
                  @permission('crear.aplicacion')
                  <div class="form-group">
                 
                   <button type="button" onclick="location.href = '{{ URL::to('apps/create') }}';" class="btn btn-primary" style="color:#FFFFFF; background-color:#2d5986; "><b>Nueva solución</b></button>
                  </div>
                  @endpermission

                  <br/>
                  @if (Session::has('message'))
	                  <div class="alert alert-success alert-dismissible fade in" role="alert">
	                    <button id="alertmsgcreation" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	                    </button>
	                    <strong>{{ Session::get('message') }}</strong>
	                  </div>
	                  @endif
	               @if (Session::has('failmessage'))
	                  <div class="alert alert-warning alert-dismissible fade in" role="alert">
	                    <button id="alertmsgfaildelete" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	                    </button>
	                    <strong>{{ Session::get('failmessage') }}</strong>
	                  </div>
	                  @endif
		                  <div class="x_content">
		                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
		                      <thead>
		                        <tr style="color:#FFFFFF; background-color:#2d5986; ">
		                          <th>Aplicación</th>
		                          <th>Empresa</th>
		                          <th>RFC empresa</th>
		                          <th>Uso</th>
		                          <th>Megas asignados</th>
		                          <th>Acciones</th>
		                          
		                        </tr>
		                      </thead>

		                      <tbody>
		                      @foreach ($apps as $a)
		                        <tr>
		                          <td>{{$a->aplicacion->app_nom}}</td>
		                          <td>{{$a->empresa ? $a->empresa->empr_nom: ''}}</td>
		                          <td>{{$a->empresa ? $a->empresa->empr_rfc: ''}}</td>
		                          <td>{{$a->uso}}</td>
		                          <td>{{$a->bdapp_gigdisp}}</td>
		                          <td width="14%">
			                          <div class="btn-group">
										<div class="btn-group">
		                          			@permission('asociar.usuario')
		                          			<button id="btnmodal{{$a->id}}" type="button" class="btn btn-xs" data-placement="left" title="Agregar usuario" style=" color:#053666; background-color:#FFFFFF; " onclick="getrolepermissionbd({{$a->id}});"><i class="fa fa-user fa-3x"></i> </button>
		                          			@endpermission

		                          			<div class="modal fade bs-example-modal-lg{{$a->id}}" tabindex="-1" role="dialog" aria-hidden="true" name="relatemodal" id="modalusr{{$a->id}}">
		                          			     <meta name="csrf-token" content="{{ csrf_token() }}" />
		                          			    
								                    <div class="modal-dialog modal-lg">
								                      <div class="modal-content">

								                        <div class="modal-header">
								                          <button type="button" class="close" data-dismiss="modal">
								                          </button>
								                          <h4 class="modal-title" id="myModalLabela"></h4>
								                          <label class="control-label col-md-12 col-sm-12 col-xs-12">{{$a->aplicacion->app_nom}} de {{$a->empresa->empr_nom}}</label>
								                        </div>
								                        <div class="modal-body">
			                        						
			                        						<form id="modalforma">
			                        						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			                             						<select class="js-example-data-array form-control" tabindex="-1" name="select_usr_id" id="select_usr_id{{$a->id}}" style="width:100%;" onchange="showroles(this,{{$a->id}})";>
				                            						<option value="null">Seleccione un usuario...</option>
				                            						@foreach($usrs as $u)
				                                					<option value="{{ $u->id }}">{{ $u->name }}</option>
				                           							@endforeach
				                          						</select>
			                          						</div>
			                          						<br>	
		                          							<br>
			                          						<div class="item form-group col-md-12 col-sm-12 col-xs-12 hidden" id="divroles{{$a->id}}">
					                                          <select class="js-example-data-array form-control col-md-12 col-sm-12 col-xs-12" name="roles[]" id="roles{{$a->id}}" multiple="multiple" style="width:100%;" >
											                  </select>
					                                        </div>

					                                        <br>	
		                          							<br>

		                          							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
				                          							<button id="addid" type="button" class="btn btn-primary" onclick="relatedb({{$a->id}});">Agregar</button>
			                          						</div>

		                          								<br>	
		                          								<br>
		                            							<div class="col-md-12 col-sm-12 col-xs-12">
				                             						<table id="datatable-buttons{{$a->id}}" class="table table-striped table-bordered">
		                      												<thead>
		                        												<tr>
		                          													<th>Nombre de usuario</th>
		                          													<th>Correo electrónico</th>
		                          													<th>Teléfono</th>
		                          													<th>Acciones</th>
		                        												</tr>
		                      												</thead>

		                      												<tbody>
		                      												@foreach ($a->users as $usr)
		                        												<tr id="row{{ $usr->id }}{{ $a->id }}">
		                          												<td>{{$usr->name}}</td>
		                          												<td>{{$usr->email}}</td>
		                          												<td>{{$usr->users_tel}}</td>
		                          												<td>
		                          													<div class="btn-group{{ $usr->id }}{{ $a->id }}">
													                          			<a id="desvusrbtn{{ $usr->id }}{{ $a->id }}" onclick="unrelatedb({{$usr->id}},{{$a->id}});" class="btn btn-xs" data-placement="left" title="Desasociar usuario" style=" color:#053666; background-color:#FFFFFF;"><i class="fa fa-close fa-3x"></i> </a>
														                          	</div>
		                          												</td>
		                          												</tr>
		                          											@endforeach
		                          											<div id="result_success{{$a->id}}"></div>
		                          											</tbody>
		                          									</table>
				                          						</div>
				                          						<div id="result_failure{{$a->id}}"></div>
	                          								</form>
								                        </div>
								                        <div class="modal-footer">
								                          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cleanFailureDiv({{$a->id}});">Cerrar</button>
								                          
								                        </div>

								                      </div>
								                    </div>
								                  </div>
			                          	</div>

			                          	<div class="btn-group">
		                          			<button id="btn_bit{{$a->id}}" class="btn btn-xs" data-placement="left" title="Ver bitácora" style=" color:#053666; background-color:#FFFFFF; "><i class="fa fa-eye fa-3x" onclick="showModalBit({{ $a->id }})"></i> </button>


		                          			<div class="modal fade{{$a->id}} bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" name="relatemodal" id="bit{{$a->id}}">
		                          			     <meta name="csrf-token" content="{{ csrf_token() }}" />
		                          			    
								                    <div class="modal-dialog modal-lg">
								                      <div class="modal-content">

								                        <div class="modal-header">
								                          <button type="button" class="close" data-dismiss="modal">
								                          </button>
								                          <h4 class="modal-title" id="myModalLabel"></h4>
								                          <label class="control-label col-md-12 col-sm-12 col-xs-12">Bitácora de {{$a->aplicacion->app_nom}} de  {{$a->empresa->empr_nom}}</label>
								                        </div>
								                        <div class="modal-body">
			                        						<form id="modalform">
		                            							<div class="col-md-12 col-sm-12 col-xs-12">
				                             						<table id="datatable-buttons-bit{{$a->id}}" class="table table-striped table-bordered">
		                      												<thead>
		                        												<tr id="header{{$a->id}}">
		                          													<th>Fecha</th>
		                          													<th>Operación</th>
		                          													<th>IP</th>
															                        <th>Módulo</th>
															                        <th>Navegador</th>
		                        												</tr>
		                      												</thead>
		                      												<tbody id="datatable-body-bit{{$a->id}}">
		                          											</tbody>
		                          									</table>
				                          						</div>
				                          						<div id="result_sinbitc{{$a->id}}" class="col-md-12 col-sm-12 col-xs-12">

				                          						</div>
	                          								</form>
								                        </div>
								                        <div class="modal-footer">
								                          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cleanBitTable({{$a->id}});">Cerrar</button>
								                          
								                        </div>

								                      </div>
								                    </div>
								                  </div>
			                          	</div>



			                          	<div class="btn-group">
		                          			<button id="btnshare{{$a->id}}" class="btn btn-xs" data-placement="left" title="Transferir megas" style=" color:#053666; background-color:#FFFFFF; "><i class="fa fa-share fa-3x" onclick="showModalShare({{ $a->id }})"></i> </button>


		                          			<div class="modal fade bs-example-modal-lg{{$a->id}}" tabindex="-1" role="dialog" aria-hidden="true" name="share" id="share{{$a->id}}">
		                          			     <meta name="csrf-token" content="{{ csrf_token() }}" />
		                          			    
								                    <div class="modal-dialog modal-lg">
								                      <div class="modal-content">

								                        <div class="modal-header">
								                          <button type="button" class="close" data-dismiss="modal">
								                          </button>
								                          <h4 class="modal-title" id="myModalLabel"></h4>
								                          <label class="control-label col-md-12 col-sm-12 col-xs-12">Transferir megas de solución de aplicación {{$a->aplicacion->app_nom}} de empresa {{$a->empresa->empr_nom}}</label>
								                        </div>
								                        <div class="modal-body">
			                        						<form id="modalform">
		                            							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					                             						<select class="js-example-data-array form-control" tabindex="-1" name="select_bd_transf_id" id="select_bd_transf_id{{$a->id}}" style="width:100%;" >
					                            						<option value="null">Seleccione una solución para recibir megas...</option>
					                            						@foreach($apps as $ad)
					                                						<option value="{{ $ad->id }}">{{ $ad->empresa->empr_nom }} {{ $ad->aplicacion->app_nom }}</option>
					                           							@endforeach
				                          							</select>
				                          						</div>
				                          						 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
											                        <input id="cant_transf{{ $a->id }}" class="form-control has-feedback-left" name="cant_transf" type="number" title="Megas a transferir" required value="{{ $a->bdapp_gigdisp }}">
											                        <span class="fa fa-pie-chart form-control-feedback left" aria-hidden="true"></span>
											                      </div>
											                      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
				                          							<button id="btnshare{{$a->id}}" type="button" class="btn btn-primary" onclick="transferirMegas({{$a->id}});">Agregar</button>
			                          								</div>
											                      <input type="hidden" id="appmegdisp{{$a->id}}" name="appmegdisp" value="{{ $a->bdapp_gigdisp }}">

				                          						<div id="result_notrasnf{{$a->id}}" class="col-md-12 col-sm-12 col-xs-12">

				                          						</div>
	                          								</form>
								                        </div>
								                        <div class="modal-footer">
								                          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cleanModalShare({{$a->id}});">Cerrar</button>
								                          
								                        </div>

								                      </div>
								                    </div>
								                  </div>
			                          	</div>



			                          		@permission('eliminar.aplicacion')
			                          		{{ Form::open(['route' => ['apps.destroy', $a->id], 'class'=>'pull-right']) }}
				                          	{{ Form::hidden('_method', 'DELETE') }}
		                      				<button  href="{{ route('empresas.destroy', $a->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar" style=" color:#053666; background-color:#FFFFFF; "><i class="fa fa-trash fa-3x" onclick="return confirm('Al realizar esta acción se eliminará la base de datos de aplicación correspondiente con todos sus datos, así como los backups guardados en el sistema de dicha base de datos. ¿Está seguro que quiere eliminar este registro?')"></i></button>
											{{ Form::close() }}
											@endpermission

			                          	</div>
		                          </td>
		                        </tr>
		                        @endforeach
	                       
		                      </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>
			</div>
		</div>

  @endsection

  @section('app_js') 
	    @parent
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
	    	<script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
	    	<script src="{{ asset('build/js/custom.js') }}"></script>

	   <script>
	      $( function() {
	          $('#alertmsgcreation').click(function() {
	              console.log('alertmsgcreation button clicked');3
	          });
	          
	         setTimeout(function() {
	              $('#alertmsgcreation').trigger('click');
	          }, 4e3);
	      });
	    </script>

	    <script>
      		$( function() {
          		$('#alertmsgfaildelete').click(function() {
             	console.log('alertmsgfaildelete button clicked');
          		});
          
         	setTimeout(function() {
              $('#alertmsgfaildelete').trigger('click');
          }, 4e3);
      });
    </script>

    <script>

    	function cleanBitTable(bdid){
			var table = document.getElementById("datatable-buttons-bit"+bdid);
   			var rowCount = table.rows.length;

			while(table.rows.length > 1) {

			  table.deleteRow(1);
			}
		}

	    function showModalBit(bdid) {
	          var modalid = "bit"+bdid;
	          $("#"+modalid).modal('show');
	          $("#result_sinbitc"+bdid).html('');
	          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	           $.ajax({
	        	url:"/getbitbd",
	        	type:'POST',
	        	cache:false,
	        	data: {_token: CSRF_TOKEN,bdid:bdid},
    			dataType: 'JSON',

	        	success:function(response){
	        		if (response['status'] == 'success'){
	        			var bit = response['result'];
	        			var table = document.getElementById("datatable-buttons-bit"+bdid);
	        			console.log(bit[0]);

	        			if (bit.length > 0) {
				            for (var i = 0; i < bit.length; i++) {

				              var row = table.insertRow(i+1);
				              
				              var cell0 = row.insertCell(0);
				              cell0.innerHTML = bit[i].bitc_fecha;

				              var cell1 = row.insertCell(1);
				              cell1.innerHTML = bit[i].bitcta_tipo_op;

				              var cell2 = row.insertCell(2);
				              cell2.innerHTML = bit[i].bitcta_ip;
				             
				              var cell5 = row.insertCell(3);
				              cell5.innerHTML = bit[i].bitc_modulo;

				              var cell6 = row.insertCell(4);
				              cell6.innerHTML = bit[i].navegador;
				            }
				          }
	        		}
	        		else
	        		{
	        			$("#result_sinbitc"+bdid).html(response['msg']);
	        		}

	        },
	        error: function(XMLHttpRequest, textStatus, errorThrown) { 
	        		console.log(XMLHttpRequest);
                    alert("Error: " + errorThrown); 
                } 
	    	});

	    }



	    	function relatedb(bdid){

	    		cleanFailureDiv(bdid);
	    		var usrid = document.getElementById("select_usr_id"+bdid).value;
	    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    		var roles = $("#roles"+bdid).val();

		        $.ajax({
		        	url:"/addbdusr",
		        	type:'POST',
		        	cache:false,
		        	data: {_token: CSRF_TOKEN,roles:roles,usrid:usrid,bdid:bdid},
	    			dataType: 'JSON',

		        	success:function(response){
		        		if (response['status'] == 'Success'){
		        			$("#datatable-buttons"+bdid).append(response['result']);

		        		}
		        		else{
		        			$("#result_failure"+bdid).html(response['result']);

		        			//console.log($(".result_failure"+bdid));
		        		}
		        		cleanusersandroles(bdid);

		        },
		        error: function(XMLHttpRequest, textStatus, errorThrown) { 
		        		console.log(XMLHttpRequest);
	                    alert("Error: " + errorThrown); 
	                } 
		    	});
		    	
		    };


	    function unrelatedb(usrid, bdid){
	    	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    		
	        $.ajax({
	        	url:"/unrbdusr",
	        	type:'POST',
	        	cache:false,
	        	data: {_token: CSRF_TOKEN,usrid:usrid,bdid:bdid},
    			dataType: 'JSON',

	        	success:function(response){
	        		//console.log(response);
	        		if (response['status'] == 'success'){
	        			console.log(response['status']);
	        			console.log(document.getElementById("row"+usrid+bdid));
	        			document.getElementById("row"+usrid+bdid).outerHTML="";

	        			//var row = document.getElementById("row"+usrid+bdid);
    					//row.parentNode.removeChild(row);

	        			//$("#datatable-buttons"+bdid).append(response['result']);
	        			cleanFailureDiv(bdid);
	        			cleanusersandroles(bdid);
	        		}
	        		else
	        		{
	        			$("#result_failure"+bdid).html(response['msg']);
	        		}
		        },
		        error: function(XMLHttpRequest, textStatus, errorThrown) { 
		        		console.log(XMLHttpRequest);
		        		console.log("Error: " + errorThrown);
		        		console.log("text: " + textStatus);
		        		console.log('usrid: '+usrid);
	    				console.log('bdid: '+bdid);
		        		//$("#result_failure"+bdid).html(response['result']);
	                } 
	    	});
	    }


	    function cleanFailureDiv(bdid){
			$("#result_failure"+bdid).html('');

			}

		function cleanusersandroles(bdid){
			document.getElementById("select_usr_id"+bdid).value = 'null';
			//$("#select_usr_id"+bdid).val() = 'null';
			$("#select_usr_id"+bdid).select2({
	              allowClear: true,
	              placeholder: 'Seleccione un usuario...'
	               
	           });
			$("#roles"+bdid).val('').change();
			$("#divroles"+bdid).addClass('hidden');
		}
	   
	    function getrolepermissionbd(bdid){

	        cleanusersandroles(bdid);
	    	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    	$("#modalusr"+bdid).modal('show');
	    	console.log('abre modal de usuario');
	        $.ajax({
	        	url:"/getrolesbd/"+bdid,
	        	type:'POST',
	        	cache:false,
	        	data: {_token: CSRF_TOKEN},
    			dataType: 'JSON',

	        	success:function(response){
	        		if (response['status'] == 1){
	        			var roles = response['roles'];
	        			console.log(roles);
	        			
						//$('.chosen-select', this).chosen('destroy').chosen();
	        			var datarole = [];
	        			if (roles.length > 0) {
				            for (var i = 0; i < roles.length; i++) {
				              var dic = {'id': roles[i]['id'], 'text': roles[i]['name']};
				              //console.log(roles[i]['slug']);
				              datarole.push(dic);
				            }
			          }
			          
	        		}
	        		else
	        		{
	        			$("#result_failure"+bdid).html(response['result']);
	        			console.log($(".result_failure"+bdid));
	        		}

	        		$("#roles"+bdid).select2({
			                  data: datarole,
			                  allowClear: true,
			                  placeholder: 'Roles...',
			                   
			             });
	        },
	        error: function(XMLHttpRequest, textStatus, errorThrown) { 
	        		console.log(XMLHttpRequest);
                    alert("Error: " + errorThrown); 
                } 

	    	});
	    

	    };

	    function showroles(element, bdid)
	    {
	    	console.log($("#select_usr_id"+bdid).val());
	    	if ($("#select_usr_id"+bdid).val() == 'null')
	    	{
	    		console.log('es nulo');
	    		$("#divroles"+bdid).addClass('hidden');
	    	}
	    	else
	    	{
	    		console.log('tiene valor');
	    		$("#divroles"+bdid).removeClass('hidden');
	    	}
	    		
	    	
	    }



	    function showModalShare(bdid) {
	          var modalid = "share"+bdid;
	          $("#"+modalid).modal('show');
	          $("#result_notrasnf"+bdid).html('');
	    }

	    function cleanModalShare(bdid_orig,bdid_dest,cant_megas){

	    	var modalid = "share"+bdid;
	        $("#"+modalid).modal('hide');
	        var orig_meg_old = document.getElementById('appmegdisp'+bdid_orig);
	        var dest_meg_old = document.getElementById('appmegdisp'+bdid_dest);

	        document.getElementById('cant_transf'+bdid_orig).value = orig_meg_old - cant_megas;
	        document.getElementById('cant_transf'+bdid_dest).value = dest_meg_old + cant_megas;
	        document.getElementById('appmegdisp'+bdid_orig).value = orig_meg_old - cant_megas;
	        document.getElementById('appmegdisp'+bdid_dest).value = dest_meg_old + cant_megas;
	    }

	    function transferirMegas(bdid)
	    {
	    	$("#result_notrasnf"+bdid).html('');

	    	if ($("#select_bd_transf_id"+bdid).val() == 'null')
	    	{
	    		$msg = "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'> "+'Debe escoger una opción'+"</label>";
	    		$("#result_notrasnf"+bdid).html($msg);
	    	}

	    	else if ($("#select_bd_transf_id"+bdid).val() == bdid)
	    	{
	    		$msg = "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'> "+'No puede transferir megas a la misma solución'+"</label>";
	    		$("#result_notrasnf"+bdid).html($msg);
	    	}
	    	else
	    	{	
	    		var bdid_dest 
	    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    		var cant_megas = document.getElementById('cant_transf'+bdid);
	    		var bdid_dest = $("#select_bd_transf_id"+bdid).val();

	    		$.ajax({
	        	url:"/transfmegas",
	        	type:'POST',
	        	cache:false,
	        	data: {_token: CSRF_TOKEN,bdid_orig:bdid,bdid_dest:bdid_dest,cant_megas:cant_megas},
    			dataType: 'JSON',

	        	success:function(response){
	        		if (response['status'] == 'success'){
	        			cleanModalShare(bdid, bdid_dest, cant_megas);
	        		}
	        		else
	        		{
	        			$("#result_notrasnf"+bdid).html(response['msg']);
	        		}
	        },
	        error: function(XMLHttpRequest, textStatus, errorThrown) { 
	        		console.log(XMLHttpRequest);
                    alert("Error: " + errorThrown); 
                } 

	    	});

	    	}

	    }



	</script>

	@endsection
  @extends('admin.template.main')


@section('title')
      Usuarios
@endsection 

@section('app_css')
    @parent
    <!-- Datatables -->
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
		        <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Lista de Usuarios</h2>
		                    <div class="clearfix"></div>
		                  </div>
		                  
		                  <div class="form-group">
		                  <a href="{{ URL::to('usuarios/create') }}"><i class="fa fa-edit right"></i> <b>Crear nuevo usuario</b></a>
		                  </div>

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
		                    
		                    <table id="datatable-buttons" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Nombre</th>
		                          <th>Usuario</th>
		                          <th>Correo</th>
		                          <th>Teléfono</th>
		                          <th>Fecha de último acceso</th>
		                          <th>Acciones</th>
		                          
		                        </tr>
		                      </thead>


		                      <tbody>
		                      @foreach ($usuarios as $u)
		                        <tr>
		                          <td>{{$u->name}}</td>
		                          <td>{{$u->users_nick}}</td>
		                          <td>{{$u->email}}</td>
		                          <td>{{$u->users_tel}}</td>
		                          <td>{{$u->users_f_ultacces}}</td>
		                          <td class=" last" width="11.5%">
		                          	
			                          <div class="btn-group">
			                          	<div class="btn-group">
		                          			<button onclick="location.href = 'usuarios/{{$u->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#790D4E"><i class="fa fa-edit fa-2x"></i> </button>
			                          	</div>

										<div class="btn-group">

		                          			<button id="btnmodal" data-usrid="{{$u->id}}" type="button" data-toggle="modal" data-target=".bs-example-modal-lg{{$u->id}}" class="btn btn-xs" data-placement="left" title="Agregar a base de datos de aplicación" style=" color:#790D4E"><i class="fa fa-plus-square fa-2x"></i> </button>

		                          				
		                          			     <div class="modal fade bs-example-modal-lg{{$u->id}}" tabindex="-1" role="dialog" aria-hidden="true" name="relatemodal" id="{{$u->id}}">
		                          			     <meta name="csrf-token" content="{{ csrf_token() }}" />
		                          			    
								                    <div class="modal-dialog modal-lg">
								                      <div class="modal-content">

								                        <div class="modal-header">
								                          <button type="button" class="close" data-dismiss="modal">
								                          </button>
								                          <h4 class="modal-title" id="myModalLabel"></h4>
								                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Usuario: {{$u->name}}</label>
								                        </div>
								                        <div class="modal-body">
			                        						
				                        						<div class="col-md-4 col-sm-4 col-xs-12">
				                             						<select class="select2_single form-control col-md-6 col-xs-12" name="select_bd_id" id="select_bd_id{{$u->id}}">
					                            						<option value="null">Seleccione una base de datos ...</option>
					                            						@foreach($apps as $ap)
					                                					<option value="{{ $ap->id }}">{{ $ap->bdapp_nombd }}</option>
					                           							@endforeach
					                          						</select>
				                          						</div>

				                          						<div class="col-md-2 col-sm-2 col-xs-12">
				                          								<button id="addid" type="button" class="btn btn-primary" onclick="relatedb({{$u->id}});">Agregar</button>
				                          						</div>

				                          						<div class="col-md-3 col-sm-3 col-xs-12">
				                          								<p></p>
				                          						</div>
		                          								<br>	
		                          								<br>
		                            							<div class="col-md-12 col-sm-12 col-xs-12">
				                             						 <table id="datatable-buttons{{$u->id}}" class="table table-striped table-bordered">
		                      												<thead>
		                        												<tr>
		                          													<th>Nombre de base de datos</th>
		                          													<th>Aplicación</th>
		                          													<th>Empresa</th>
		                          													<th>RFC de empresa</th>


		                        												</tr>
		                      												</thead>

		                      												<tbody>
		                      												@foreach ($u->basedatosapps as $bd)
		                        												<tr>
		                          												<td>{{$bd->bdapp_nombd}}</td>
		                          												<td>{{$bd->bdapp_app}}</td>
		                          												<td>{{$bd->empresa->empr_nom}}</td>
		                          												<td>{{$bd->empresa->empr_rfc}}</td>
		                          												</tr>
		                          											@endforeach
		                          											<div id="result_success{{$u->id}}"></div>
		                          											</tbody>
		                          										</table>
				                          							</div>

				                          						<div id="result_failure{{$u->id}}"></div>

	                          								
								                        </div>
								                        <div class="modal-footer">
								                          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cleanFailureDiv({{$u->id}});">Cerrar</button>
								                          
								                        </div>

								                      </div>
								                    </div>
								                  </div>

			                          	</div>

			                          		{{ Form::open(['route' => ['usuarios.destroy', $u->id], 'class'=>'pull-right']) }}
				                          	{{ Form::hidden('_method', 'DELETE') }}
		                      				<button  href="{{ route('usuarios.destroy', $u->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar" style=" color:#790D4E" onclick="return confirm('El usuario también será eliminado de todas las bases de datos de aplicación a las que esté asociado. ¿Está seguro que quiere eliminar este registro?')"><i class="fa fa-trash fa-2x"></i></button>
											{{ Form::close() }}

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
	    	<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
	    	<script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
	    	<script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
	    	<script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
	    	<script src="{{ asset('build/js/custom.js') }}"></script>

   <script>
      $( function() {
          $('#alertmsgcreation').click(function() {
              console.log('alertmsgcreation button clicked');
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
	   		
	   		/*function addPerson(nombd,app,emp,rfc) {
	  			const row = createRow({
	    		nombd: nombd,
	    		app: app,
	    		emp: emp,
	    		rfc: rfc,
	  			$('table tbody').append(row);
			}

	function createRow(data) {
	  return (
	    `<tr>` +
	      `<td>${$('tbody tr').length + 1}</td>` +
	      `<td>${data.name}</td>` +
	      `<td>${data.lastname}</td>` +
	    `</tr>`
	 );
	}*/		function cleanFailureDiv(usrid){

			$("#result_failure"+usrid).html('');

			}

	
	    	function relatedb(usrid){
	    		
	    		var bdid = document.getElementById("select_bd_id"+usrid).value;
	    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    		
	        $.ajax({
	        	url:"/addusrdb/"+usrid+"/"+bdid,
	        	//data:"usrid="+ usrid + "& bdid=" + bdid,
	        	type:'POST',
	        	cache:false,
	        	data: {_token: CSRF_TOKEN},
    			dataType: 'JSON',

	        	success:function(response){
	        		if (response['status'] == 'Success'){
	        			console.log($(".result_success"+usrid));
	        			$("#datatable-buttons"+usrid).append(response['result']);
	        			cleanFailureDiv(usrid);

	        		}
	        		else{
	        			$("#result_failure"+usrid).html(response['result']);
	        			console.log($(".result_failure"+usrid));
	        		}

	        		document.getElementById("select_bd_id"+usrid).value = 'null';

	        		console.log(response);

	        },
	        error: function(XMLHttpRequest, textStatus, errorThrown) { 
	        		console.log(XMLHttpRequest);
                    alert("Error: " + errorThrown); 
                } 


	    });
	    };
	</script>
@endsection
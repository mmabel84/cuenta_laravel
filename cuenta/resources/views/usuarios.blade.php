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
    <link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
    
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
		                  <button type="button" onclick="location.href = '{{ URL::to('usuarios/create') }}';" class="btn btn-primary" style="color:#FFFFFF; background-color:#053666; ">Nuevo usuario</button>
		                  </div>

		                  <br/>
		                  	<div class="alert alert-success alert-dismissible fade in" role="alert" id="divpasschange" style="display: none;">
			                    <button id="alertpasschange" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			                    </button>
			                    <strong id="alertpassmsg"></strong>
			                 </div>
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
		                        <tr style="color:#FFFFFF; background-color:#053666; ">
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
		                          <td class=" last" width="18%">
		                          	
			                          <div class="btn-group">
			                          	<div class="btn-group">
		                          			<button onclick="location.href = 'usuarios/{{$u->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#053666; background-color:#FFFFFF; "><i class="fa fa-edit fa-3x"></i> </button>
			                          	</div>

										<div class="btn-group">

		                          			<button id="btnmodal" data-usrid="{{$u->id}}" type="button" data-toggle="modal" class="btn btn-xs" data-placement="left" title="Agregar a aplicación" style=" color:#053666; background-color:#FFFFFF; " onclick="showModalBD({{$u->id}})"><i class="fa fa-database fa-3x"></i> </button>

		                          				
		                          			     <div class="modal fade bs-example-modal-lg{{$u->id}}" tabindex="-1" role="dialog" aria-hidden="true" name="relatemodal" id="modalUsrBd{{$u->id}}">
		                          			     <meta name="csrf-token" content="{{ csrf_token() }}" />
		                          			    
								                    <div class="modal-dialog modal-lg">
								                      <div class="modal-content">

								                      <div class="modal-header">
	                                                      <h5 class="modal-title" id="exampleModalLabel">Usuario: {{$u->name}}</h5>
	                                                      <button type="button" class="close" data-dismiss="modal">
	                                                      </button>
                                                    	</div>

								                        <div class="modal-body">
								                        <form>
			                        						<div class="col-md-12 col-sm-12 col-xs-12">
			                             						<select class="select2_single form-control col-md-6 col-xs-12" name="select_bd_id" id="select_bd_id{{$u->id}}" style="width:100%;" onclick="fillroles(this, {{ $u->id }});">
				                            						<option value="null">Seleccione una base de datos ...</option>
				                            						@foreach($apps as $ap)
				                                					<option value="{{ $ap->id }}">{{ $ap->empresa->empr_nom }} {{ $ap->aplicacion->app_nom }}</option>
				                           							@endforeach
				                          						</select>
			                          						</div>
			                          						<br>	
		                          							<br>

			                          						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						                                          <select class="js-example-data-array form-control col-md-12 col-sm-12 col-xs-12" name="roles[]" id="roles{{$u->id}}" multiple="multiple" style="width:100%;" >
												                  </select>

					                                        </div>
					                                        <br>	
		                          							<br>
			                          						<div class="col-md-2 col-sm-2 col-xs-12">
			                          								<button id="addid" type="button" class="btn btn-primary" onclick="relatedb({{$u->id}});">Agregar</button>
			                          						</div>
			                          						<div class="col-md-3 col-sm-3 col-xs-12">
			                          							<p></p>
			                          						</div>
			                          						<br>
			                          						<br>
			                          						<br>
	                            							<div class="col-md-12 col-sm-12 col-xs-12">
			                             						 <table id="datatable-buttons{{$u->id}}" class="table table-striped table-bordered">
	                      												<thead>
	                        												<tr>
	                          													<th>Aplicación</th>
	                          													<th>Empresa</th>
	                          													<th>RFC de empresa</th>
	                          													<th>Acciones</th>


	                        												</tr>
	                      												</thead>

	                      												<tbody>
	                      												@foreach ($u->basedatosapps as $bd)
	                        												<tr id="row{{ $bd->id }}">
	                          												<td>{{$bd->aplicacion->app_nom}}</td>
	                          												<td>{{$bd->empresa->empr_nom}}</td>
	                          												<td>{{$bd->empresa->empr_rfc}}</td>
	                          												<td>
		                          													<div class="btn-group{{ $bd->id }}">
													                          			<button id="desvusrbtn{{ $bd->id }}" onclick="unrelatedb({{ $bd->id }}, {{ $u->id }});" class="btn btn-xs" data-placement="left" title="Desasociar base de datos" style=" color:#053666; background-color:#FFFFFF;"><i class="fa fa-close fa-3x"></i> </button>
														                          	</div>
		                          												</td>
	                          												</tr>
	                          											@endforeach
	                          											<div id="result_success{{$u->id}}"></div>
	                          											</tbody>
	                          										</table>
			                          							</div>

				                          					</form>

								                        </div>
								                        <div class="modal-footer">
								                        <div id="result_failure{{$u->id}}" class="col-md-9 col-sm-9 col-xs-12"></div>
								                          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cleanFailureDiv({{$u->id}});">Cerrar</button>
								                          
								                        </div>

								                      </div>
								                    </div>
								                  </div>

			                          	</div>

			                          	<div class="btn-group">
                                              

                                                <button id="passmodallink{{$u->id}}" data-usrid="{{$u->id}}" type="button" data-toggle="modal" data-target=".passmodal{{$u->id}}" class="btn btn-xs" data-placement="left" title="Cambiar contraseña" style=" color:#053666; background-color:#FFFFFF; " onclick="showModal({{$u->id}})"><i class="fa fa-key fa-3x"></i> </button>


                                              <div class="modal fade" id="passmodal{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Cambio de contraseña: {{$u->name}}</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <form>
                                                        <div class="form-group">
                                                          <input placeholder="Contraseña" required="required" type="password" class="form-control" id="password{{$u->id}}">
                                                        </div>
                                                      </form>

                                                     <div id="result_failure{{$u->id}}"></div>

                                                   </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                      <button type="button"  onclick="changePass({{$u->id}});" class="btn btn-primary">Ok</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>


                                         </div>

			                          		{{ Form::open(['route' => ['usuarios.destroy', $u->id], 'class'=>'pull-right']) }}
				                          	{{ Form::hidden('_method', 'DELETE') }}
		                      				<button  href="{{ route('usuarios.destroy', $u->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar" style=" color:#053666; background-color:#FFFFFF; " onclick="return confirm('El usuario también será eliminado de todas las bases de datos de aplicación a las que esté asociado. ¿Está seguro que quiere eliminar este registro?')"><i class="fa fa-trash fa-3x"></i></button>
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
	    	<script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
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

		
	function cleanRoles(usrid){
			$("#roles"+usrid).select2({
				                  allowClear: true,
				                  placeholder: 'Sin roles...'
				             });
			$("#roles"+usrid).empty();

			}


		function cleanFailureDiv(usrid){

			$("#result_failure"+usrid).html('');
			document.getElementById("select_bd_id"+usrid).value = 'null';
			cleanRoles(usrid);

			}

	
	    	function relatedb(usrid){
	    		
	    		var bdid = document.getElementById("select_bd_id"+usrid).value;
	    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    		var roles = $("#roles"+usrid).val();
	    		
	        $.ajax({
	        	url:"/addusrdb",
	        	type:'POST',
	        	cache:false,
	        	data: {_token: CSRF_TOKEN,roles:roles,usrid:usrid,bdid:bdid},
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
	        			cleanRoles(usrid);
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


	    function unrelatedb(bdid, usrid){
	    		
	    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    		document.getElementById("row"+bdid).outerHTML="";
	    			    		
	        $.ajax({
	        	url:"/unrbdusr",
	        	type:'POST',
	        	cache:false,
	        	data: {_token: CSRF_TOKEN,usrid:usrid,bdid:bdid},
    			dataType: 'JSON',

	        	success:function(response){
	        		if (response['status'] == 'Success'){
	        			console.log(response);
	        			cleanFailureDiv(usrid);

	        		}
	        		else{
	        			$("#result_failure"+usrid).html(response['result']);
	        		}

	        		document.getElementById("select_bd_id"+usrid).value = 'null';

	        },
	        error: function(XMLHttpRequest, textStatus, errorThrown) { 
	        		console.log(XMLHttpRequest);
                    alert("Error: " + errorThrown); 
                } 


	    });
	    };


	    function fillroles(element, usrid){
	    		
	    		$("#roles"+usrid).empty();

	    		var bdid = element.value;
	    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	    		if (element.value == 'null'){
	    			cleanRoles(usrid);
	    		}
	    		else
	    		{
	    			$.ajax({
		        	url:"/getrolesbd/"+bdid,
		        	type:'POST',
		        	cache:false,
		        	data: {_token: CSRF_TOKEN},
	    			dataType: 'JSON',

		        	success:function(response){
		        		if (response['status'] == 'Success'){
		        			//console.log(response['roles']);
		        			var roles = response['roles'];
		        			
							//$('.chosen-select', this).chosen('destroy').chosen();
		        			var datarole = [];
		        			if (roles.length > 0) {
					            for (var i = 0; i < roles.length; i++) {
					              var dic = {'id': roles[i]['slug'], 'text': roles[i]['name']};
					              //console.log(roles[i]['slug']);
					              datarole.push(dic);
					            }
					            $("#roles"+usrid).select2({
					                  data: datarole,
					                  allowClear: true,
					                  placeholder: 'Seleccione los roles...'
					                   
					             });
					          }
		        		}
		        		else{
		        			$("#result_failure"+bdid).html(response['result']);
		        			console.log($(".result_failure"+bdid));
		        		}

			        },
			        error: function(XMLHttpRequest, textStatus, errorThrown) { 
			        		console.log(XMLHttpRequest);
		                    alert("Error: " + errorThrown); 
	                } 


		    		});

	    		}
	    		
	        
	    };

	    function showModal(user) {
          var modalid = "passmodal"+user;

          $("#"+modalid).modal('show');
          
        }

        function showModalBD(user) {
          var modalid = "modalUsrBd"+user;

          $("#"+modalid).modal('show');
          cleanRoles(user);
        }

       function hideModal(user) {
          var modalid = "passmodal"+user;
          $("#"+modalid).modal('hide');
          cleanRoles(user);
        }


       function changePass(user){

           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

           var passid = "password"+user;

           var password = document.getElementById(passid).value;



           if(password){
              $.ajax({
                url: 'cambcont',
                type: 'POST',
                data: {_token: CSRF_TOKEN,password:password,user:user},
                dataType: 'JSON',
                success: function (data) {

                 //console.log(data);
                  hideModal(data['user']);
                  //$('#alertmsgcreation').trigger('click');

                  document.getElementById("divpasschange").style.display = 'block';
                  document.getElementById("alertpassmsg").innerHTML = data['msg'];
                  setTimeout(function() {
		              $('#alertpasschange').trigger('click');
		          }, 4e3);
                  

               },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                }
            });
            }else{
              $("#result_failure"+user).html('<p><strong>La contraseña es obligatoria</strong></p>');
              
           }

           document.getElementById("password"+user).value = "";

   }


	</script>



	
@endsection
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

		                          				<form id="form1">
		                          				
		                          			     <div class="modal fade bs-example-modal-lg{{$u->id}}" tabindex="-1" role="dialog" aria-hidden="true">
		                          			     <!-- CSRF Token -->
    												<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
												<!-- ./ csrf token -->
								                    <div class="modal-dialog modal-lg">
								                      <div class="modal-content">

								                        <div class="modal-header">
								                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
								                          </button>
								                          <h4 class="modal-title" id="myModalLabel">Agregar usuario a base de datos</h4>
								                        </div>
								                        <div class="modal-body">
								                           <div class="form-group">
			                        						<label class="control-label col-md-4 col-sm-4 col-xs-12">Usuario</label>
				                       							<div class="col-md-4 col-sm-4 col-xs-12">
				                             						<select class="select2_single form-control col-md-6 col-xs-12" name="select_usr_id" id="select_usr_id">
					                            						<option value="null">Seleccione un usuario ...</option>
					                            						@foreach($usuarios as $ur)
					                                					<option value="{{ $ur->id }}" {{$u->id == $ur->id ? 'selected':''}}>{{ $ur->name }}</option>
					                           							@endforeach
					                          						</select>
				                          						</div>
				                        					</div>
				                        					<div class="form-group">
				                        						<label class="control-label col-md-4 col-sm-4 col-xs-12">Base de datos</label>
				                        						<div class="col-md-4 col-sm-4 col-xs-12">
				                             						<select class="select2_single form-control col-md-6 col-xs-12" name="select_bd_id" id="select_bd_id">
					                            						<option value="null">Seleccione una base de datos ...</option>
					                            						@foreach($apps as $ap)
					                                					<option value="{{ $ap->id }}">{{ $ap->bdapp_nombd }}</option>
					                           							@endforeach
					                          						</select>
				                          						</div>
	                          								</div>
	                          								<br>	
	                          								<br>

	                          								<div class="form-group">
				                        						<label class="control-label col-md-12 col-sm-12 col-xs-12">Base de datos relacionadas</label>
		                            								<div class="col-md-12 col-sm-12 col-xs-12">
				                             						 <table id="datatable-buttons" class="table table-striped table-bordered">
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
		                          											</tbody>
		                          										</table>
				                          							</div>
	                          								</div>

	                          								<div id="result_msg"></div>
								                        </div>
								                        <div class="modal-footer">
								                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								                          <button id="addid" type="submit" class="btn btn-primary">Agregar</button>
								                        </div>

								                      </div>
								                    </div>
								                  </div>
								                 </form>



			                          	</div>

			                          		
			                          		{{ Form::open(['route' => ['usuarios.destroy', $u->id], 'class'=>'pull-right']) }}
				                          	{{ Form::hidden('_method', 'DELETE') }}
		                      				<button  href="{{ route('usuarios.destroy', $u->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar" style=" color:#790D4E"><i class="fa fa-trash fa-2x"></i></button>
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

	<script type="text/javascript">
	    $('.btn btn-primary').click(function(){
	    	var usrid=$('select_usr_id').val();
	    	var bdid=$('select_bd_id').val();
	        $.ajax({
	        	url:"/addusrdb/{"+usrid+","+bdid+"}",
	        	method:'POST',
	        	cache:false,
	        	success:function(result){
	            $(".result_msg").html(result);
	        }});
	    });
	</script>
@endsection
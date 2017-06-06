@extends('admin.template.main')


@section('title')
      Aplicaciones
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
		                    <h2>Lista de bases de datos de aplicación</h2>
		                    <div class="clearfix"></div>
		                  </div>
		                  
		                  <div class="form-group">
		                  <a href="{{ URL::to('apps/create') }}"><i class="fa fa-edit right"></i> <b>Generar nueva base de datos de aplicación</b></a>
		                  </div>

		                  <br/>
		                  @if (Session::has('message'))
			                  <div class="alert alert-success alert-dismissible fade in" role="alert">
			                    <button id="alertmsgcreation" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			                    </button>
			                    <strong>{{ Session::get('message') }}</strong>
			                  </div>
			                  @endif

		                  <div class="x_content">
		                    
		                    <table id="datatable-buttons" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Aplicación</th>
		                          <th>Empresa</th>
		                          <th>Nombre de base de datos</th>
		                          <th>Nombre de servidor</th>
		                          <th>Acciones</th>
		                          
		                        </tr>
		                      </thead>


		                      <tbody>
		                      @foreach ($apps as $a)
		                        <tr>
		                          <td>{{$a->bdapp_app}}</td>
		                          <td>{{$a->empresa ? $a->empresa->empr_nom: ''}}</td>
		                          <td>{{$a->bdapp_nombd}}</td>
		                          <td>{{$a->bdapp_nomserv}}</td>

		                          <td class=" last" width="11.5%">
		                          	
		                          	
			                          <div class="btn-group">
			                          	<div class="btn-group">
		                          			<button onclick="location.href = 'apps/{{$a->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#790D4E"><i class="fa fa-edit fa-2x"></i> </button>
			                          	</div>

										<div class="btn-group">
		                          			<button onclick="" class="btn btn-xs" data-placement="left" title="Agregar usuario" style=" color:#790D4E"><i class="fa fa-plus-square fa-2x"></i> </button>
			                          	</div>

			                          		
			                          		{{ Form::open(['route' => ['apps.destroy', $a->id], 'class'=>'pull-right']) }}
				                          	{{ Form::hidden('_method', 'DELETE') }}
		                      				<button  href="{{ route('empresas.destroy', $a->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar" style=" color:#790D4E"><i class="fa fa-trash fa-2x"></i></button>
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
	@endsection
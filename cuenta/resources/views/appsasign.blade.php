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
		                    <h2>Lista de aplicaciones asignadas</h2>
		                    
		                    <div class="clearfix"></div>
		                  </div>

		                  <div class="form-group" style="visibility: hidden;">
		                  <a href="{{ URL::to('appsasign/create') }}"><i class="fa fa-edit right"></i> <b>Crear nueva aplicación</b></a>
		                  </div>
		                  
		                  
		                  <br/>
		                 		                  
		                  <div class="x_content">
		                    
		                    <table id="datatable-buttons" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Nombre</th>
		                          <th>Código</th>
		                          <th>Acciones</th>
		                        </tr>
		                      </thead>
		                      <tbody>
		                      	@foreach ($apps as $a)
		                        <tr>
		                          <td>{{$a->app_nom}}</td>
		                          <td>{{$a->app_cod}}</td>
		                          <td>
		                          <div class="btn-group">
			                          	<div class="btn-group">
		                          			<button onclick="#" class="btn btn-xs" data-placement="left" title="Ver roles y permisos" style=" color:#790D4E"><i class="fa fa-unlock-alt fa-2x"></i> </button>
			                          	</div>
			                         </div>
		                          	<!--<div class="btn-group">
		                          		<p></p>
		                          		{{ Form::open(['route' => ['appsasign.destroy', $a->id], 'class'=>'pull-right']) }}
			                          	{{ Form::hidden('_method', 'DELETE') }}
	                      				<button  href="{{ route('appsasign.destroy', $a->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar" style=" color:#790D4E"><i class="fa fa-trash fa-2x"></i></button>
										{{ Form::close() }}


		                          	</div>-->

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

	    	
   
@endsection          
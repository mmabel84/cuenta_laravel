    @extends('admin.template.main')


@section('app_title')
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

		                 
		                  <br/>
		                 		                  
		                  <div class="x_content">
		                    
		                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
		                      <thead>
		                        <tr style="color:#FFFFFF; background-color:#254d74;">
		                          <th>Nombre</th>
		                          <th>Código</th>
		                          <th>Cantidad de instancias contratadas</th>
		                          <th>Cantidad de megas contratados</th>
		                          <th>Estado</th>
		                        </tr>
		                      </thead>
		                      <tbody>
		                      	@foreach ($apps as $a)
		                        <tr>
		                          <td>{{$a->app_nom}}</td>
		                          <td>{{$a->app_cod}}</td>
		                          <td>{{$a->app_insts}}</td>
		                          <td>{{$a->app_megs}}</td>
		                          <td>{{ $a->app_activa == 1 ? 'Activa' : 'Deshabilitada' }}</td>
		                          
		                         
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
	    	<script src="{{ asset('build/js/custom.js') }}"></script>

	    	
   
@endsection          
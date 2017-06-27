 @extends('admin.template.main')


@section('app_title')
      Bitácora
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
		                    <h2>Bitácora</h2>
		                    
		                    <div class="clearfix"></div>
		                  </div>
		                  <br/>
		                 
		                  <div class="x_content">
		                    
		                    <table id="datatable-buttons" class="table table-striped table-bordered">
		                      <thead>
		                        <tr style="color:#FFFFFF; background-color:#254d74; ">
		                          <th>Fecha</th>
		                          <th>Operación</th>
		                          <th>IP</th>
		                          <th>Navegador</th>
		                          <th>Mensaje</th>
		                          <th>Módulo</th>
		                          <th>Dato</th>
		                          <th>Resultado</th>
		                          
		                        </tr>
		                      </thead>


		                      <tbody>
		                      	@foreach ($bitacoras as $b)
		                        <tr>
		                          <td>{{$b->bitc_fecha}}</td>
		                          <td>{{$b->bitcta_tipo_op}}</td>
		                          <td>{{$b->bitcta_ip}}</td>
		                          <td>{{$b->bitcta_naveg}}</td>
		                          <td>{{$b->bitcta_msg}}</td>
		                          <td>{{$b->bitc_modulo}}</td>
		                          <td>{{$b->bitcta_dato}}</td>
		                          <td>{{$b->bitcta_result}}</td>
		                      
		                          		                          
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
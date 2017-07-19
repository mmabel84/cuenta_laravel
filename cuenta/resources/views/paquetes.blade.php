 @extends('admin.template.main')


@section('app_title')
      Paquetes
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
		                    <h2>Líneas de tiempo</h2>
		                    
		                    <div class="clearfix"></div>
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
		                    
		                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
		                      <thead>
		                        <tr style="color:#FFFFFF; background-color:#254d74; ">
		                         
		                          <th>Fecha de venta</th>
		                          <th>Fecha de activación</th>
		                          <th>Fecha de fin</th>
		                          <th>Fecha de caducidad</th>
		                          <th>Estado</th>
		                          
		                        </tr>
		                      </thead>
		                      <tbody>
		                      	@foreach ($paqs as $p)
		                        <tr>
		                          
		                          <td>{{$p->paqapp_f_venta}}</td>
		                          <td>{{$p->paqapp_f_act}}</td>
		                          <td>{{$p->paqapp_f_fin}}</td>
		                          <td>{{$p->paqapp_f_caduc}}</td>
		                          <td>{{ $p->paqapp_activo == 1 ? 'Activa' : 'Vencida' }}</td>
		                          
		                         
		                          		                          
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

   
@endsection   
   @extends('admin.template.main')


@section('app_title')
      Certificados
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
		                    <h2>Lista de certificados</h2>
		                    
		                    <div class="clearfix"></div>
		                  </div>
		                  
		                  @permission('crear.certificado')
		                  <div class="form-group">
		                  <button type="button" onclick="location.href = '{{ URL::to('certificados/create') }}';" class="btn btn-primary" style="color:#FFFFFF; background-color:#2d5986; "><b>Nuevo certificado</b></button>
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
		                    
		                    <table id="datatable-buttons" class="table table-striped table-bordered">
		                      <thead>
		                        <tr style="color:#FFFFFF; background-color:#2d5986 ">
		                          <th>RFC</th>
		                          <th>Razón social</th>
		                          <th>Número de serie</th>
		                          <th>Tipo</th>
		                          <th>Vencimiento</th>
		                          <th>Estado</th>
		                          <th>Acciones</th>
		                         
		                          
		                        </tr>
		                      </thead>


		                      <tbody>
		                      	@foreach ($certs as $cert)
		                        <tr>
		                          <td>{{ $cert->cert_rfc }}</td>
		                          <td>{{ $cert->cert_raz_soc }}</td>
		                          <td>{{ $cert->cert_serial }}</td>
		                          <td>{{ $cert->cert_tipo }}</td>
		                          <td>{{ $cert->cert_f_fin }}</td>
		                          <td>{{ $cert->cert_estado }}</td>
		                          
		                          <td class=" last" width="5%">
		                          <div>
		                          	
		                          	<div class="btn-group">
		                          		<p></p>
		                          		@permission('eliminar.certificado')
		                          		{{ Form::open(['route' => ['certificados.destroy', $cert->id], 'class'=>'pull-right']) }}
			                          	{{ Form::hidden('_method', 'DELETE') }}
	                      				<button  href="{{ route('certificados.destroy', $cert->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar respaldo" style=" color:#053666; background-color:#FFFFFF; "><i class="fa fa-trash fa-3x"></i></button>
										{{ Form::close() }}
										@endpermission

		                          	</div>
		                          	   	


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
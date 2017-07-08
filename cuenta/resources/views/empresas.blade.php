 @extends('admin.template.main')


@section('app_title')
      Empresas
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
		                    <h2>Lista de Empresas</h2>
		                    
		                    <div class="clearfix"></div>
		                  </div>
		                  
		                  <div class="form-group">
		                  <button type="button" onclick="location.href = '{{ URL::to('empresas/create') }}';" class="btn btn-round btn-primary" style="color:#000033; background-color:#ccebff; "><b>Nueva empresa</b></button>
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
		                        <tr style="color:#000033; background-color:#ccebff; ">
		                          <th>Nombre</th>
		                          <th>RFC</th>
		                          <th>Razón social</th>
		                          <th>Acciones</th>
		                          
		                        </tr>
		                      </thead>

		                      <tbody>
		                      	@foreach ($empresas as $e)
		                        <tr>
		                          <td>{{$e->empr_nom}}</td>
		                          <td>{{$e->empr_rfc}}</td>
		                          <td>{{$e->empr_razsoc}}</td>
		                          
		                          <td width="12%">
		                          <div>
		                          	
		                          	<div class="btn-group">
		                          		<p></p>
		                          		{{ Form::open(['route' => ['empresas.destroy', $e->id], 'class'=>'pull-right']) }}
			                          	{{ Form::hidden('_method', 'DELETE') }}
	                      				<button  href="{{ route('empresas.destroy', $e->id) }}" class="btn btn-xs" type="submit" data-placement="left" title="Borrar" style=" color:#053666; background-color:#FFFFFF; "><i class="fa fa-trash fa-3x"></i></button>
										{{ Form::close() }}

										&nbsp;
										<div class="btn-group">
		                          			<button onclick="location.href = 'empresas/{{$e->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#053666; background-color:#FFFFFF;"><i class="fa fa-edit fa-3x"></i> </button>
			                          	</div>

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
 @extends('admin.template.main')


@section('title')
      Lista de empresas
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
		                    <ul class="nav navbar-right panel_toolbox">
		                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		                      </li>
		                      <li class="dropdown">
		                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
		                        <ul class="dropdown-menu" role="menu">
		                          <li><a href="#">Settings 1</a>
		                          </li>
		                          <li><a href="#">Settings 2</a>
		                          </li>
		                        </ul>
		                      </li>
		                      <li><a class="close-link"><i class="fa fa-close"></i></a>
		                      </li>
		                    </ul>
		                    <div class="clearfix"></div>
		                  </div>
		                  
		                  <div class="form-group">
		                  	<a href="{{ URL::to('empresas/create') }}"><i class="fa fa-edit right"></i> <b>Crear nueva empresa</b></a>
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
		                          
		                          <td class=" last" width="12%">
		                          <div>
		                          	<div class="btn-group">
		                          		<a href="{{route('empresas.edit',['id'=>$e->id])}}" class="btn btn-info btn-xs" data-placement="left" title="Editar"><i class="fa fa-edit fa-2x"></i> </a>
		                          	</div>

		                          	<div class="btn-group">
		                          		<p></p>
		                          		{{ Form::open(array('url' => 'empresas/' . $e->id, 'class' => 'pull-right')) }}
			                          	{{ Form::hidden('_method', 'DELETE') }}
	                      				<button href="{{route('empresas.destroy',['id'=>$e->id])}}" class="btn btn-danger btn-xs" type="submit" data-placement="left" title="Borrar"><i class="fa fa-trash fa-2x"></i></button>
										{{ Form::close() }}
		                          	</div>


		                          	<div class="btn-group">
						                    <button data-toggle="dropdown" class="fa fa-plus-square fa-2x btn btn-success dropdown-toggle btn-sm btn-xs right" type="button" aria-expanded="false"><span class="caret"></span>
						                    </button>
						                    <ul role="menu" class="dropdown-menu">
						                      
						                    </ul>
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
    <!-- Datatables -->
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.js') }}"></script>

   <script>
      $( function() {
          $('#alertmsgcreation').click(function() {
              console.log('alertmsgcta button clicked');
          });
          
         setTimeout(function() {
              $('#alertmsgcreation').trigger('click');
          }, 4e3);
      });
    </script>
@endsection
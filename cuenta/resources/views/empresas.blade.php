 @extends('admin.template.maintable')


@section('title')
      Lista de empresas
@endsection 

@section('content')

	
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
			                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			                    </button>
			                    <strong>{{ Session::get('message') }}</strong>
			                  </div>
			                  @endif
		                  <div class="x_content table-responsive">
		                    
		                    <table id="datatable" class="table table-striped table-bordered">
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
		                          <td class=" last" width="16.5%">
		                          	
                            		<a href="{{route('empresas.edit',['id'=>$e->id])}}" class="btn btn-info btn-xs" type="button"><i class="fa fa-pencil"></i> Editar </a>

                      				{{ Form::open(array('url' => 'empresas/' . $e->id, 'class' => 'pull-right')) }}
		                          	{{ Form::hidden('_method', 'DELETE') }}
                      				<button href="{{route('empresas.destroy',['id'=>$e->id])}}" class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> Eliminar </button>
									<div class="btn-group">
						                    <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-sm btn-xs right" type="button" aria-expanded="false">Más <span class="caret"></span>
						                    </button>
						                    <ul role="menu" class="dropdown-menu">
						                      <li><a href="#">Action</a>
						                      </li>
						                      <li><a href="#">Another action</a>
						                      </li>
						                      <li><a href="#">Something else here</a>
						                      </li>
						                      <li><a href="#">Separated link</a>
						                      </li>
						                    </ul>
									     </div>

									  {{ Form::close() }}

		                          </td>
		                          
		                        </tr>
		                        @endforeach
		                       		                       
		                      </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>


@endsection
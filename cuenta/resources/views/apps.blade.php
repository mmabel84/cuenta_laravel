    @extends('admin.template.maintable')


@section('title')
      Lista de Instancias
@endsection 

@section('content')

	


			<div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Lista de bases de datos de aplicación</h2>
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

		                  <div class="x_content table-responsive">
		                    
		                    <table id="datatable" class="table table-striped table-bordered bulk_action">
		                      <thead>
		                        <tr>
		                          <th class="column-title">Aplicación</th>
		                          <th class="column-title">Empresa</th>
		                          <th class="column-title">Nombre de base de datos</th>
		                          <th class="column-title">Nombre de servidor</th>
		                          <th class="column-title no-link last"><span class="nobr">Acciones</span>
		                          
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
		                          	
                            		<a href="{{route('apps.edit',['id'=>$a->id])}}" class="btn btn-info btn-xs" data-placement="left" title="Editar"><i class="fa fa-edit fa-2x"></i> </a>

                      				{{ Form::open(array('url' => 'apps/' . $a->id, 'class' => 'pull-right')) }}
		                          	{{ Form::hidden('_method', 'DELETE') }}
                      				<button href="{{route('apps.destroy',['id'=>$a->id])}}" class="btn btn-danger btn-xs" type="submit" data-placement="left" title="Borrar"><i class="fa fa-trash fa-2x"></i></button>
									<div class="btn-group">
						                    <button data-toggle="dropdown" class="fa fa-plus-square fa-2x btn btn-success dropdown-toggle btn-sm btn-xs right" type="button" aria-expanded="false"><span class="caret"></span>
						                    </button>
						                    <ul role="menu" class="dropdown-menu">
						                      <li><a href="#">Agregar usuario</a>
                                              </li>
						                    </ul>
									     </div>

									  {{ Form::close() }}

		                          </td>

		                        </tr>
		                        @endforeach
		                        <tr>
		                       
		                      </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>

		              @section('formjs')
		              @parent
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

		          	
		          	



@endsection
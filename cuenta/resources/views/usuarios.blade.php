  @extends('admin.template.maintable')


@section('title')
      Lista de usuarios
@endsection 

@section('content')

		
			<div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Lista de Usuarios</h2>
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
		                  <a href="{{ URL::to('usuarios/create') }}"><i class="fa fa-edit right"></i> <b>Crear nuevo usuario</b></a>
		                  </div>

		                  <br/>

		                  <div class="x_content table-responsive">
		                    
		                    <table id="datatable" class="table table-striped table-bordered bulk_action">
		                      <thead>
		                        <tr>
		                          <th class="column-title">Nombre</th>
		                          <th class="column-title">Usuario</th>
		                          <th class="column-title">Correo</th>
		                          <th class="column-title">Teléfono</th>
		                          <th class="column-title">Fecha de último acceso</th>
		                          <th class="column-title no-link last"><span class="nobr">Acciones</span>
		                          
		                        </tr>
		                      </thead>


		                      <tbody>
		                      @foreach ($usuarios as $u)
		                        <tr>
		                          <td>{{$u->name}}</td>
		                          <td>{{$u->users_nick}}</td>
		                          <td>{{$u->email}}</td>
		                          <td>{{$u->users_tel}}</td>
		                          <td>{{$u->users_f_ultacces}}</td>
		                          <td class=" last" width="11.5%">
		                          	
                            		<a href="{{route('usuarios.edit',['id'=>$u->id])}}" class="btn btn-info btn-xs" data-placement="left" title="Editar"><i class="fa fa-edit fa-2x"></i> </a>

                      				{{ Form::open(array('url' => 'usuarios/' . $u->id, 'class' => 'pull-right')) }}
		                          	{{ Form::hidden('_method', 'DELETE') }}
                      				<button href="{{route('usuarios.destroy',['id'=>$u->id])}}" class="btn btn-danger btn-xs" type="submit" data-placement="left" title="Borrar"><i class="fa fa-trash fa-2x"></i></button>
									<div class="btn-group">
						                    <button data-toggle="dropdown" class="fa fa-plus-square fa-2x btn btn-success dropdown-toggle btn-sm btn-xs right" type="button" aria-expanded="false"><span class="caret"></span>
						                    </button>
						                    <ul role="menu" class="dropdown-menu">
						                      
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
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
		                  	<a href="/usuario"><i class="fa fa-edit right"></i> <b>Crear nuevo usuario</b></a>
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
		                        <tr>
		                          <td>Usuario 1</td>
		                          <td>usr1</td>
		                          <td>usr1@gmail.com</td>
		                          <td>6463355426</td>
		                          <td>25/02/2017</td>
		                          <td class=" last">
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-edit"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Ver información"><i class="fa fa-file-o"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Borrar"><i class="fa fa-trash"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Asociar a instancias"><i class="fa fa-plus-square"></i></a>

		                          </td>
		                          
		                        </tr>
		                        <tr>
		                          <td>Usuario 2</td>
		                          <td>usr2</td>
		                          <td>usr2@gmail.com</td>
		                          <td>6464635426</td>
		                          <td>10/04/2017</td>
		                          <td class=" last">
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-edit"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Ver información"><i class="fa fa-file-o"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Borrar"><i class="fa fa-trash"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Asociar a instancias"><i class="fa fa-plus-square"></i></a>
		                          </td>
		                        </tr>
		                       
		                      </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>


@endsection 
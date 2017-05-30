    @extends('admin.template.maintable')


@section('title')
      Lista de Instancias
@endsection 

@section('content')

	


			<div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Lista de Instancias</h2>
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
		                  	<a href="/instancia"><i class="fa fa-edit right"></i> <b>Generar nueva instancia</b></a>
		                  </div>

		                  <br/>

		                  <div class="x_content table-responsive">
		                    
		                    <table id="datatable" class="table table-striped table-bordered bulk_action">
		                      <thead>
		                        <tr>
		                          <th class="column-title">Aplicación</th>
		                          <th class="column-title">Empresa</th>
		                          <th class="column-title">Nombre de base de datos</th>
		                          <th class="column-title no-link last"><span class="nobr">Acciones</span>
		                          
		                        </tr>
		                      </thead>


		                      <tbody>
		                        <tr>
		                          <td>Contabilidad</td>
		                          <td>Empresa 1</td>
		                          <td>bd_empresa_1</td>
		                          <td class=" last">
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-edit"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Ver información"><i class="fa fa-file-o"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Borrar"><i class="fa fa-trash"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Agregar RFC"><i class="fa fa-sitemap"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Agregar Proveedores"><i class="fa fa-users"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Agregar Usuarios"><i class="fa fa-user"></i></a>




		                          </td>
		                          
		                        </tr>
		                        <tr>
		                         <td>Contabilidad</td>
		                          <td>Empresa 2</td>
		                          <td>bd_empresa_2</td>
		                          <td class=" last">
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-edit"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Ver información"><i class="fa fa-file-o"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Borrar"><i class="fa fa-trash"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Agregar RFC"><i class="fa fa-sitemap"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Agregar Proveedores"><i class="fa fa-users"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Agregar Usuarios"><i class="fa fa-user"></i></a>

		                          </td>
		                          
		                        </tr>
		                       
		                      </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>

		          	
		          	



@endsection
    @extends('admin.template.maintable')


@section('title')
      Lista de RFCs
@endsection 

@section('content')

	


			<div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Lista de RFCs</h2>
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
		                  	<a href="/rfcempresa"><i class="fa fa-edit right"></i> <b>Crear nuevo RFC</b></a>
		                  </div>

		                  <br/>

		                  <div class="x_content table-responsive">
		                    
		                    <table id="datatable" class="table table-striped table-bordered bulk_action">
		                      <thead>
		                        <tr>
		                          <th class="column-title">Nombre RFC</th>
		                          <th class="column-title">RFC</th>
		                          <th class="column-title">Empresa a que pertenece</th>
		                          <th class="column-title no-link last"><span class="nobr">Acciones</span>
		                          
		                        </tr>
		                      </thead>


		                      <tbody>
		                        <tr>
		                           <td>Empresa X</td>
		                          <td>1234567897654</td>
		                          <td>Empresa 1</td>
		                          <td class=" last">
		                          <a href="#" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-edit"></i></a>
		                          <a href="#" data-toggle="tooltip" data-placement="left" title="Ver información"><i class="fa fa-file-o"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Borrar"><i class="fa fa-trash"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Ver instancias"><i class="fa fa-sitemap"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Añadir a instancias"><i class="fa fa-plus-square"></i></a>

		                          </td>
		                          
		                        </tr>
		                        <tr>
		                          <td>Empresa Y</td>
		                          <td>2345432567895</td>
		                           <td>Empresa 2</td>
		                          <td class=" last">
		                          <a href="#" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-edit"></i></a>
  		                          <a href="#" data-toggle="tooltip" data-placement="left" title="Ver información"><i class="fa fa-file-o"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Borrar"><i class="fa fa-trash"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Ver instancias"><i class="fa fa-sitemap"></i></a>
		                          	<a href="#" data-toggle="tooltip" data-placement="left" title="Añadir a instancias"><i class="fa fa-plus-square">

		                          </td>
		                          
		                        </tr>
		                       
		                      </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>


@endsection
 @extends('admin.template.mainform')


@section('title')
      Instancias
@endsection 

@section('content')
	

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos de Instancia</h2>
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
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aplicación</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_single form-control" tabindex="-1">
                              <option></option>
                              <option value="E1">Contabilidad</option>
                              <option value="E2">Bóveda</option>
                              
                            </select>
                          </div>
                     </div>

                     

	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Empresa</label>
	                          <div class="col-md-6 col-sm-6 col-xs-12">
	                            <select class="select2_single form-control" tabindex="-1">
	                              <option></option>
	                              <option value="E1">Empresa 1</option>
	                              <option value="E2">Empresa 2</option>
	                              
	                            </select>
	                          </div>
	                        </div>

	                        <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">RFCs</label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <select class="select2_multiple form-control" multiple="multiple">
	                            <option>Seleccione RFCs para instancia</option>
	                            <option>RFC 1</option>
	                            <option>RFC 2</option>
	                            <option>RFC 3</option>
	                          </select>
	                        </div>
	                      </div>

	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Proveedores</label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <select class="select2_multiple form-control" multiple="multiple">
	                            <option>Seleccione proveedores para instancia</option>
	                            <option>Proveedor 1</option>
	                            <option>Proveedor 2</option>
	                            <option>Proveedor 3</option>
	                          </select>
	                        </div>
	                      </div>

                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button">Agregar instancia</button>
                        </div>
                      </div>

                      <div class="divider-dashed"></div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Instancias a generar</h2>
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
		                  <div class="x_content">

		                    <table class="table table-striped">
		                      <thead>
		                        <tr>
		                          <th>#</th>
		                          <th>Aplicación</th>
		                          <th>Empresa</th>
		                          <th>RFCs</th>
		                          <th>Proveedores</th>
		                        </tr>
		                      </thead>
		                      <tbody>
		                        <tr>
		                          <th scope="row">1</th>
		                          <td>Contabilidad</td>
		                          <td>Empresa 1</td>
		                          <td>RFC 1, RFC 2</td>
		                          <td>Proveedor 1, Proveedor 2</td>
		                        </tr>
		                        <tr>
		                          <th scope="row">2</th>
		                          <td>Contabilidad</td>
		                          <td>Empresa 2</td>
		                          <td>RFC 3</td>
		                          <td>Proveedor 1, Proveedor 2</td>
		                        </tr>

		                      </tbody>
		                    </table>

		                  </div>
		                </div>
		              </div>



                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button">Cancelar</button>
						  <button class="btn btn-primary" type="reset">Limpiar</button>
                          <button type="submit" class="btn btn-success">Generar instancias</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


@endsection
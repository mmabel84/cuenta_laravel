@extends('admin.template.mainform')


@section('title')
      Usuarios
@endsection 

@section('content')


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos de Usuario</h2>
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
	                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres</label>
	                       <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	                        <input type="text" class="form-control has-feedback-right" id="inputSuccess2" >
	                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
	                      </div>
                      </div>
                      <div class="form-group">
	                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Apellidos</label>
	                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	                        <input type="text" class="form-control" id="inputSuccess3" >
	                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
	                      </div>
                      </div>

                      <div class="form-group">
                     	 <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo</label>
	                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	                        <input type="text" class="form-control has-feedback-right" id="inputSuccess4">
	                        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
	                      </div>
                      </div>

                      <div class="form-group">
                      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono</label>
	                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	                        <input type="text" class="form-control" id="inputSuccess5">
	                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
	                      </div>
                      </div>

                      <div class="form-group">
                      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre de usuario</label>
	                       <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	                        <input type="text" class="form-control has-feedback-right" id="inputSuccess2">
	                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
	                      </div>
                      </div>

                      <div class="form-group">
                      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña</label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input type="password" class="form-control has-feedback-right" value="">
	                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
	                        </div>
                       </div>

                        <div class="form-group">
                          <label class="col-md-3 col-sm-3 col-xs-12 control-label">Roles de Cuenta
                            <br>
                            <small class="text-navy"></small>
                          </label>

                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="flat" checked="checked"> Rol 1
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="flat"> Rol 2
                                </label>
                              </div>
                                                     
                           </div>
                        
                          </div>
                        <script type="text/javascript">
                          function showAddInst() {
                              element = document.getElementById("addinstdiv");
                              check = document.getElementById("addinstcheck");
                              if (check.checked) {
                                  element.style.display='block';
                              }
                              else {
                                  element.style.display='none';
                              }
                          }
                      </script>
                        
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <div class="">
                                <label>
                                  <input type="checkbox" id="addinstcheck" class="js-switch" onchange="showAddInst()"  unchecked /> Asociar a instancias
                                </label>

                                

                              </div>
                          </div>
                        </div>

                      <div class="form-group" id="addinstdiv" style="display: none;">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Instancia</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select class="select2_single form-control" tabindex="-1" name="select_instance">
                                <option></option>
                                <option value="E1">Instancia 1</option>
                                <option value="E2">Instancia 2</option>
                                
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Roles de instancia</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_multiple form-control" multiple="multiple">
                              <option>Seleccione roles de instancia</option>
                              <option>Rol 1</option>
                              <option>Rol 2</option>
                              <option>Rol 3</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="button">Asociar instancia</button>
                            </div>
                        </div>

                        <div class="form-group">

                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                             <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>Instancia</th>
                                  <th>Roles de Instancia</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>Instancia 1</td>
                                  <td>Rol1, Rol2 </td>
                                </tr>
                                <tr>
                                  <td>Instancia 2</td>
                                  <td>Rol3, Rol4</td>
                                </tr>

                              </tbody>
                            </table>
                          </div>
                         </div>

                      </div>
                      </div>


                        <div class="x_content">

             
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button">Cancelar</button>
						  <button class="btn btn-primary" type="reset">Limpiar</button>
                          <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                      </div>
                     

                    </form>
                  </div>
                </div>
              </div>

@endsection
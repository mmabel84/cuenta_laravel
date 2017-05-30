@extends('admin.template.mainform')


@section('title')
      RFC de Empresa
@endsection 

@section('content')
	

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos de RFC</h2>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Empresa que pertenece</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_single form-control" tabindex="-1">
                              <option></option>
                              <option value="E1">Empresa 1</option>
                              <option value="E2">Empresa 2</option>
                              
                            </select>
                          </div>
                        </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre de RFC <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">RFC <span class="required">*</span> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control" data-inputmask="'mask' : '*************'">
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
	                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="message">Razón social (20 caracteres min, 100 max)</label>
	                          <div class="col-md-6 col-sm-6 col-xs-12">
		                          <textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
		                            data-parsley-validation-threshold="10"></textarea>
                            	</div>
                    	</div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Instancias</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_multiple form-control" multiple="multiple">
                              <option>Seleccione instancias para agregar RFC</option>
                              <option>Instancia 1</option>
                              <option>Instancia 2</option>
                              <option>Instancia 3</option>
                            </select>
                          </div>
                        </div>
                      
                      
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
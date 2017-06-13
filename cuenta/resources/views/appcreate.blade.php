 @extends('admin.template.mainform')


@section('title')
      Aplicaciones
@endsection 

@section('content')
	
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Crear base de datos de aplicación</h2>
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
                    @if (Session::has('message'))
	                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
	                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	                    </button>
	                    <strong>{{ Session::get('message') }}</strong>
	                  </div>
                  @endif
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('apps.store')}}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aplicación</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_single form-control" tabindex="-1" name="bdapp_app_id" id="bdapp_app_id">
                               <option value="null">Seleccione una aplicación ...</option>
                                @foreach($aplicaciones as $app)
                                    <option value="{{ $app->id }}">{{ $app->app_nom }}</option>
                                @endforeach
                              
                            </select>
                          </div>
                     </div>

                     

	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Empresa</label>
	                          <div class="col-md-6 col-sm-6 col-xs-12">
	                             <select class="select2_single form-control col-md-7 col-xs-12" name="bdapp_empr_id">
		                            <option value="null">Seleccione una empresa ...</option>
		                            @foreach($empresas as $empr)
		                                <option value="{{ $empr->id }}">{{ $empr->empr_nom }}</option>
		                            @endforeach
		                          </select>
	                          </div>
	                        </div>

	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre de servidor <span class="required">*</span>
	                        </label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input type="text" id="bdapp_nomserv" name="bdapp_nomserv" required="required" class="form-control col-md-7 col-xs-12">
	                        </div>
	                      </div>

	                       
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button">Cancelar</button>
						  <button class="btn btn-primary" type="reset">Limpiar</button>
                          <button type="submit" class="btn btn-success">Generar</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>



@endsection
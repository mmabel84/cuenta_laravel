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
                    <h2>Editar base de datos de aplicación</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                       
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

                    {{ Form::open(['route' => ['apps.update', $app], 'class'=>'form-horizontal form-label-left']) }}

                      {{ Form::hidden('_method', 'PUT') }}
                   
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aplicación</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_single form-control" tabindex="-1" name="bdapp_app">
                              <option></option>
                              <option value="cont" {{$app->bdapp_app == 'cont' ? 'selected':''}}>Contabilidad</option>
                              <option value="bov" {{$app->bdapp_app == 'bov' ? 'selected':''}}>Bóveda</option>
                              <option value="pld" {{$app->bdapp_app == 'pld' ? 'selected':''}}>PLD</option>
                              <option value="nom" {{$app->bdapp_app == 'nom' ? 'selected':''}}>Nómina</option>
                              <option value="not" {{$app->bdapp_app == 'not' ? 'selected':''}}>Notaría</option>
                              <option value="cc" {{$app->bdapp_app == 'cc' ? 'selected':''}}>Control de Calidad</option>
                              
                            </select>
                          </div>
                     </div>

                     

	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Empresa</label>
	                          <div class="col-md-6 col-sm-6 col-xs-12">
	                             <select class="select2_single form-control col-md-7 col-xs-12" name="bdapp_empr_id" value="{{$app->bdapp_empr_id}}">
		                            <option value="null">Seleccione una empresa ...</option>
		                            @foreach($empresas as $empr)
		                                <option value="{{ $empr->id }}" {{$app->bdapp_empr_id == $empr->id ? 'selected':''}}>{{ $empr->empr_nom }}</option>
		                            @endforeach
		                          </select>
	                          </div>
	                        </div>

	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre de servidor <span class="required">*</span>
	                        </label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input type="text" id="bdapp_nomserv" name="bdapp_nomserv" required="required" class="form-control col-md-7 col-xs-12" value="{{$app->bdapp_nomserv}}">
	                        </div>
	                      </div>

	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre de base de datos <span class="required">*</span>
	                        </label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input type="text" id="bdapp_nombd" name="bdapp_nombd" required="required" class="form-control col-md-7 col-xs-12" value="{{$app->bdapp_nombd}}">
	                        </div>
	                      </div>

	                       
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button">Cancelar</button>
						  <button class="btn btn-primary" type="reset">Limpiar</button>
                          <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>



@endsection    
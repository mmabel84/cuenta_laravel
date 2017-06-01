@extends('admin.template.mainform')


@section('title')
      Empresas
@endsection 

@section('content')
	

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Crear una empresa</h2>
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
                    

                    {{ HTML::ul($errors->all()) }}
                    
                    {{ Form::open(array('url' => 'empresas')) }}

                        <div class="form-group">
                            {{ Form::label('empr_nom', 'Nombre de empresa') }}
                            {{ Form::text('empr_nom', Input::old('empr_nom'), array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('empr_rfc', 'RFC de empresa') }}
                            {{ Form::text('empr_rfc', Input::old('empr_rfc'), array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('empr_razsoc', 'Razón social de empresa') }}
                            {{ Form::text('empr_razsoc', Input::old('empr_razsoc'), array('class' => 'form-control')) }}
                        </div>


                        {{ Form::submit('Guardar empresa', array('class' => 'btn btn-primary')) }}

                    {{ Form::close() }}

                  </div>
                </div>
              </div>

@endsection
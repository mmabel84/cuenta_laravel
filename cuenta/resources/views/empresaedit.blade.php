   @extends('admin.template.mainform')


@section('app_title')
      Empresas
@endsection 

@section('content')
	         <div class="container">
            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar una empresa</h2>
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
                  </div>
                  <div class="x_content">
                    <br />
                    

            
           	 		{{ Form::open(['route' => ['empresas.update', $empresa], 'class'=>'form-horizontal form-label-left']) }}

                      {{ Form::hidden('_method', 'PUT') }}
                      <div class="item form-group">
                       
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" id="empr_nom" name="empr_nom" required="required" class="form-control has-feedback-left" value="{{$empresa->empr_nom}}" placeholder="Nombre de empresa *">
                          <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      
                      <div class="item form-group {{ $errors->has('empr_rfc') ? 'bad' : '' }}">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" id="empr_rfc" name="empr_rfc" class="form-control has-feedback-left" data-inputmask="'mask' : '*************'" value="{{$empresa->empr_rfc}}" placeholder="RFC de empresa *" readonly>
                          <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <span style="float: left; color: red;" id="span_empr_rfc" {{$errors->has('empr_rfc') ? '' : 'hidden'}}>
                                {{ $errors->first('empr_rfc') }}
                            </span>
                        </div>
                      </div>
                      <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="empr_razsoc" type="text" required="required" class="form-control has-feedback-left" name="empr_razsoc" placeholder="Razón social de empresa " value="{{$empresa->empr_razsoc}}">
                              <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                      </div>
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button" onclick="location.href = '{{ URL::to('empresas') }}';">Cancelar</button>
                          <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                      </div>

                    {{ Form::close() }}

                  </div>
                </div>
              </div>

            </div>
          </div>


@endsection
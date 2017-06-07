@extends('admin.template.mainform')


@section('title')
      Usuarios
@endsection 

@section('content')
         <div class="container">
            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar un usuario</h2>
                       <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                    {{ Form::open(['route' => ['usuarios.update', $usr], 'class'=>'form-horizontal form-label-left']) }}

                      {{ Form::hidden('_method', 'PUT') }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$usr->name}}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('users_tel') ? ' has-error' : '' }}">
                            <label for="users_tel" class="col-md-3 control-label">Teléfono</label>

                            <div class="col-md-6">
                                <input id="users_tel" type="text" class="form-control" name="users_tel" value="{{$usr->users_tel}}">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{$usr->email}}" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('users_nick') ? ' has-error' : '' }}">
                            <label for="users_nick" class="col-md-3 control-label">Usuario</label>

                            <div class="col-md-6">
                                <input id="users_nick" type="text" class="form-control" name="users_nick" value="{{$usr->users_nick}}" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-3 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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
                                  <input type="checkbox" id="addinstcheck" class="js-switch" onchange="showAddInst()"  unchecked /> Asociar a base de datos de aplicaciones
                                </label>

                                

                              </div>
                          </div>
                        </div>

                        <div class="form-group" id="addinstdiv" style="display: none;">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Base de datos de aplicación</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select class="select2_single form-control" tabindex="-1" name="select_instance">
                                <option value="null">Seleccione una base de datos de aplicación ...</option>
                                @foreach($apps as $app)
                                    <option value="{{ $app->id }}">{{ $app->bdapp_nombd }}</option>
                                @endforeach
                                
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Roles de base de datos de aplicación</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_multiple form-control" multiple="multiple">
                              <option>Seleccione roles de instancia</option>
                              <option>Rol 1</option>
                              <option>Rol 2</option>
                              <option>Rol 3</option>
                            </select>
                          </div>
                        </div>

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
                     

                     {{ Form::close() }}

                  </div>
                </div>
              </div>


            </div>
        </div>

@endsection

@extends('admin.template.main')

@section('app_css')
    @parent
    <!-- Switchery -->
    <link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.css') }}" rel="stylesheet">
    <!-- File Input -->
    <link href="{{ asset('vendors/bootstrap-fileinput-master/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- Chosen -->

    <link href="{{ asset('vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />


    <style>
    .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
    .kv-reqd {
        color: red;
        font-family: monospace;
        font-weight: normal;
    }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Nuevo Rol</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>

                </ul>
                <div class="clearfix"></div>
              </div>
                  @if (Session::has('message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ Session::get('message') }}</strong>
                  </div>
                  @endif
              <div class="x_content">

                <!--<form class="form-horizontal form-label-left input_mask">-->
               {{ Form::open(['route' => ['roles.update', $rol], 'class'=>'form-horizontal form-label-left']) }}
               {{ Form::hidden('_method', 'PUT') }}
                    <table border="0" class="col-md-12 col-sm-12 col-xs-12">
                    <tr>
                    <td>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="name" class="form-control has-feedback-left" name="name" placeholder="Nombre del rol *" required="required" type="text" value="{{$rol->name}}">
                              <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                              @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="slug" class="form-control has-feedback-left" name="slug" placeholder="Código *" required="required" type="text" data-validate-words="1" value="{{$rol->slug}}" autocomplete="off">
                              <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                              @if ($errors->has('slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                          </div>

                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="description" class="form-control has-feedback-left" name="description" placeholder="Descripción *" required="required" data-validate-words="1" autocomplete="off" value="{{$rol->description}}">
                              <span class="fa fa-edit form-control-feedback left" aria-hidden="true"></span>
                              @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                          </div>
                          
                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="level" class="form-control has-feedback-left" name="level" placeholder="Nivel *" value="{{$rol->level}}">
                              <span class="fa fa-sitemap form-control-feedback left" aria-hidden="true"></span>
                              @if ($errors->has('level'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                @endif
                            </div>
                          </div>
                    </td>
                    </tr>
                    </table>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        </br>
                        </br>
                    </div>


                      

                        <div class="x_content">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Permisos</a>
                            </li>
                          </ul>

                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">


                                 <div class="item form-group">
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                          <select id="permisos" name="permisos[]" tabindex="2" data-placeholder="Seleccione los permisos ..." name="rolesapp" class="chosen-select form-control" multiple="multiple">

                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->id }}" {{Auth::user()->customGetRolePerms($rol->id, $permission->id, true) ? 'selected':''}}>{{ $permission->name }}</option>
                                            @endforeach
                                          </select>
                                          </div>
                                  </div>



                            </div>


                          </div>
                        </div>
                    </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="button" onclick="location.href = '{{ URL::to('roles') }}';">Cancelar</button>
                            <button id="send" type="submit" class="btn btn-success">Guardar</button>
                        </div>
                      </div>

                    </form>

              </div>
            </div>
          </div>
    </div>
</div>
@endsection

@section('app_js')
    @parent

    <!-- validator -->
    <script src="{{ asset('vendors/validator/control.validator.js') }}"></script>

    <!-- Date Time -->
    <script type="text/javascript" src="{{ asset('vendors/datetime/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('vendors/datetime/js/locales/bootstrap-datetimepicker.es.js') }}" charset="UTF-8"></script>

    <!-- Switchery -->
    <script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>

    <!-- File Input -->
    <script src="{{ asset('vendors/bootstrap-fileinput-master/js/fileinput.js') }}" type="text/javascript"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.js') }}"></script>

    <!-- Chosen -->
    <script src="{{ asset('vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

@endsection        
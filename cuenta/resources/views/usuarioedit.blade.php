
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
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet">


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
    .hidden{
            visibility:hidden;
            }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Nuevo Usuario</h2>
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
                {{ Form::open(['route' => ['usuarios.update', $user], 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal form-label-left']) }}

                    {{ Form::hidden('_method', 'PUT') }}


                    <div id="invimg">
                        <img id='imageiddef' src="{{asset('default_avatar_male.jpg')}}">
                        @if (count($user->users_pic) >= 1)
                            <img id='imageid' src="{{asset('storage/'.$user->users_pic)}}">
                        @else
                            <img id='imageid' src="{{asset('default_avatar_male.jpg')}}">
                        @endif

                        <input id="deleted_pic" name="deleted_pic" type="text" value="0">

                    </div>

                    <table border="0" class="col-md-12 col-sm-12 col-xs-12">
                    <tr>
                    <td width="25%">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="kv-avatar center-block text-center" style="width:200px">
                                    <input id="avatar-2" name="users_pic" type="file" class="file-loading">
                                </div>
                            </div>

                        </div>
                    </td>
                    <td>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="name" class="form-control has-feedback-left" name="name" placeholder="Nombre del Usuario *" required="required" type="text" value="{{$user->name}}">
                              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="users_nick" class="form-control has-feedback-left" name="users_nick" placeholder="Usuario *" required="required" type="text" data-validate-words="1" value="{{$user->users_nick}}" autocomplete="off">
                              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              @if ($errors->has('users_nick'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_nick') }}</strong>
                                    </span>
                                @endif
                            </div>
                          </div>



                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="email" class="form-control has-feedback-left" name="email" placeholder="Correo *" required="required" type="email" value="{{$user->email}}">
                              <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                              @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                          </div>

                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="users_tel" class="form-control has-feedback-left" name="users_tel" placeholder="Teléfono *" type="tel" value="{{$user->users_tel}}">
                              <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
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
                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Roles y Permisos</a>
                            </li>
                          </ul>

                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                
                                <div class="item form-group">
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                          <select id="roles" name="roles[]" tabindex="1" data-placeholder="Seleccione los roles ..." class="chosen-select form-control" onchange="onSelectUserCreate(this)" multiple="multiple">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{$user->hasRole($role->id) ? 'selected':''}} >{{ $role->name }}</option>
                                            @endforeach
                                          </select>
                                          </div>
                                  </div>

                                  <div class="item form-group">
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                          <select id="permisos" name="permisos[]" tabindex="2" data-placeholder="Seleccione los permisos ..."  class="chosen-select form-control" multiple="multiple">

                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->id }}" {{$user->customGetUserPerms($permission->id,true) ? 'selected':''}} >{{ $permission->name }}</option>
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
                        <button class="btn btn-primary" type="button" onclick="location.href = '{{ URL::to('usuarios') }}';">Cancelar</button>
                            <button id="send" type="submit" class="btn btn-success">Guardar</button>
                        </div>
                      </div>

                    {{ Form::close() }}

              </div>
            </div>
          </div>
    </div>
 <input type="hidden" name="edit" id="edit" onchange="onShowEditUser();" />
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

    

    <!-- Chosen -->
    <script src="{{ asset('vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.js') }}"></script>


    <script type="text/javascript">

    //$('#edit').trigger('change');

        function getSelectValues(select) {
          var result = [];
          var options = select && select.options;
          var opt;

          for (var i=0, iLen=options.length; i<iLen; i++) {
            opt = options[i];

            if (opt.selected) {
              result.push(opt.value || opt.text);
            }
          }
          return result;
        }


         function onSelectUserCreate(element){
             var selected = getSelectValues(element);

             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

             console.log(CSRF_TOKEN);

             $.ajax({
                url: 'permsbyroles',
                type: 'POST',
                data: {_token: CSRF_TOKEN,selected:selected},
                dataType: 'JSON',
                success: function (data) {
                    var roles = [];
                    var perms = document.getElementById('permisos').options;
                    data['permissions'].forEach(function(entry) {
                        roles.push(entry);
                        for(var i=0;i<perms.length;i++){

                          if(String(perms[i].value)==String(entry)){
                                          console.log(perms[i]);
                                          perms[i].selected=true;
                          }
                        }
                    });
                    console.log(perms);
                    $('#permisos').trigger("chosen:updated");

                }
            });
         }


         function onShowEditUser(){

             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             var email = document.getElementById('email').value;

             console.log(CSRF_TOKEN);

             $.ajax({
                url: 'permsbyroles',
                type: 'POST',
                data: {_token: CSRF_TOKEN,edit:true,email:email},
                dataType: 'JSON',
                success: function (data) {
                    var roles = [];
                    var perms = document.getElementById('permisos').options;
                    console.log(data['algo']);
                    data['permissions'].forEach(function(entry) {
                        roles.push(entry);
                        for(var i=0;i<perms.length;i++){

                          if(String(perms[i].value)==String(entry)){
                                          //console.log(perms[i]);
                                          perms[i].selected=true;
                          }
                        }
                    });
                    //console.log(perms);
                    $('#permisos').trigger("chosen:updated");

                }
            });
         }

         var imgdiv = document.getElementById("invimg");
         imgdiv.style.display='none';

         $("#avatar-2").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: true,
            showCaption: false,
            showUpload: false,
            showBrowse: true,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: "<img src={{asset('default_avatar_male.jpg')}} alt='Your Avatar' style='width:160px'><h6 class='text-muted'>Click to select</h6>",
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            browseLabel: 'Foto Usuario',
            allowedFileExtensions: ["jpg", "png", "gif"]
        });


    </script>


@endsection 
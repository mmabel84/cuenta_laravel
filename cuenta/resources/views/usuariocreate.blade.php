
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
                <form id="usercreateform" class="form-horizontal form-label-left" novalidate action="{{ route('usuarios.store') }}" method='POST' enctype="multipart/form-data">

                      {{ csrf_field() }}

                  <table border="0" class="col-md-12 col-sm-12 col-xs-12">
                    <tr>
                    <td width="25%">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <div id="imgcontainer" class="file-preview-frame">
                                    <img id='imageiddef' src="{{asset('default_avatar_male.jpg')}}" hidden>
                                    <img id="blah" alt="your image" width="150" height="150" src="{{asset('default_avatar_male.jpg')}}" />
                                    <button id="cleanpic" type="button" onclick="cleanFunc();"  class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>

                            </div>
                        </div>
                    </td>
                    <td>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="name" class="form-control has-feedback-left" name="name" placeholder="Nombre del Usuario *" required="required" type="text" value="{{ old('name') }}" title="Nombre y apellidos del usuario">
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
                              <input id="password" class="form-control has-feedback-left" value="" name="password" placeholder="Contraseña *" required="required" type="password" data-validate-words="1" autocomplete="off" title="Contraseña del usuario">
                              <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                              

                                <span style="float: left; color: red;" id="span_pass_error" {{$errors->has('password') ? '' : 'hidden'}}>
                                {{ $errors->first('password') }}
                            </span>
                            </div>
                          </div>

                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="password-confirm" class="form-control has-feedback-left" value="" name="password_confirmation" placeholder="Confirmar Contraseña *" required="required" type="password" data-validate-words="1" autocomplete="off" title="Confirmación de contraseña">
                              <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                            </div>
                          </div>

                          <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="email" class="form-control has-feedback-left" name="email" placeholder="Correo *" required="required" type="email" value="{{ old('email') }}" title="Correo electrónico del usuario">
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
                              <input id="users_tel" class="form-control has-feedback-left" name="users_tel" placeholder="Teléfono *" type="tel" value="{{ old('users_tel') }}" title="Teléfono del usuario">
                              <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                            </div>
                          </div>

                    </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="fileinputcontainer" class="col-md-6 col-sm-6 col-xs-6">
                                <input id="users_pic" name="users_pic" style='position:absolute;z-index:2;top:0;' type="file"/>
                            </div>
                        </td>
                        <td></td>
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
                                          <select id="roles" name="roles[]" tabindex="1" data-placeholder="Seleccione los roles ..." class="chosen-select form-control" onchange="onSelectUserCreate(this)" multiple="multiple" title="Roles del usuario">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                          </select>
                                          </div>
                                  </div>

                                  <div class="item form-group">
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                          <select id="permisos" name="permisos[]" tabindex="2" data-placeholder="Seleccione los permisos ..." class="chosen-select form-control" multiple="multiple" title="Permisos del usuario">

                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
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
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.js') }}"></script>

    <!-- Chosen -->
    <script src="{{ asset('vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>


    <script type="text/javascript">

        function cleanFunc(){
            $("#blah").attr("src", document.getElementById('imageiddef').src);
            $("#users_pic").val('');
        }

        $("#users_pic").on('change', function () {

             var countFiles = $(this)[0].files.length;
             console.log();
             var imgPath = $(this)[0].value;
             var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();


             if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                 if (typeof (FileReader) != "undefined") {
                     for (var i = 0; i < countFiles; i++) {

                         var reader = new FileReader();
                         reader.onload = function (e) {
                             $("#blah").attr("src", e.target.result);
                         }
                      reader.readAsDataURL($(this)[0].files[i]);
                     }

                 } else {
                     alert("This browser does not support FileReader.");
                 }
             } else {
                 alert("Pls select only images");
             }
         }); 

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

             console.log(selected);

             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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

         var imgdiv = document.getElementById("invimg");
         var form = document.getElementById("usercreateform");
         form.reset();
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
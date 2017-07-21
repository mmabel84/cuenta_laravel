
@extends('admin.template.main')

@section('app_title')
      Empresas
@endsection 

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
                <h2>Nueva Empresa</h2>
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
                <form id="emprcreateform" class="form-horizontal form-label-left" novalidate action="{{ route('empresas.store') }}" method='POST' enctype="multipart/form-data">

                      {{ csrf_field() }}

                    
                    <table border="0" class="col-md-12 col-sm-12 col-xs-12">
                    <tr>
                    
                    <td>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="empr_nom" class="form-control has-feedback-left" name="empr_nom" placeholder="Nombre de empresa *" required="required" type="text" value="{{ old('empr_nom') }}" title="Nombre de empresa">
                              <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                              
                            </div>
                        </div>

                          <div class="item form-group {{ $errors->has('empr_rfc') ? 'bad' : '' }}">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="empr_rfc" class="form-control has-feedback-left" name="empr_rfc" placeholder="RFC de empresa *" required="required" type="text" data-validate-words="1" value="{{ old('empr_rfc') }}" autocomplete="off" data-inputmask="'mask' : '*************'" style="text-transform: uppercase;" title="RFC de empresa">
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
                              <input id="empr_razsoc" class="form-control has-feedback-left" name="empr_razsoc" placeholder="Razón social de empresa " type="text" value="{{ old('empr_razsoc') }}" autocomplete="off" title="Razón social de empresa">
                              <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                             
                            </div>
                          </div>

                    </td>
                    </tr>
                    </table>



                    <div class="col-md-12 col-sm-12 col-xs-12">
                        </br>
                        </br>
                    </div>




                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="button" onclick="location.href = '{{ URL::to('empresas') }}';">Cancelar</button>
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


    <script type="text/javascript">

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
                    data['roles'].forEach(function(entry) {
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



         $("#empr_rfc").on('change', function(){
            document.getElementById("span_empr_rfc").setAttribute('hidden','1');
        });


    </script>


@endsection
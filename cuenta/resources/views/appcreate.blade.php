 @extends('admin.template.main')



@section('app_css')
    @parent
    <!-- Datatables -->
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


@endsection

@section('content')
	
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Crear solución</h2>
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
                    @if (Session::has('failmessage'))
	                  <div class="alert alert-warning alert-dismissible fade in" role="alert">
	                    <button id="alertmsgcreation" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	                    </button>
	                    <strong>{{ Session::get('failmessage') }}</strong>
	                  </div>
                  @endif
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="form2" class="form-horizontal form-label-left" novalidate method="POST" action="{{route('apps.store')}}">
                    {{ csrf_field() }}


                    <input type="hidden" id="apps" name="apps" value="{{ $aplicaciones }}">
                    <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                               <select class="js-example-basic-single js-states form-control" name="bdapp_empr_id" id="bdapp_empr_id" required title="Empresa" >
                                <option value="">Seleccione una empresa...</option>
                                @foreach($empresas as $empr)
                                    <option value="{{ $empr->id }}">{{ $empr->empr_nom }}</option>
                                @endforeach
                              </select>
                            </div>
                           
                          </div>
                    
                     <input type="hidden" id="emps" name="emps" value="{{ $empresas }}" onchange="filldata();">
	                      <div class="item form-group">
                        <!--<label class="control-label col-md-3 col-sm-3 col-xs-12">Aplicación</label>-->
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="js-example-data-array form-control" tabindex="-1" name="bdapp_app_id" id="bdapp_app_id" required="required" title="Aplicación" onchange="showMegasDisp(this);">
                               <option value="">Seleccione una aplicación ...</option>
                                @foreach($aplicaciones as $app)
                                    <option value="{{ $app->id }}">{{ $app->app_nom }}</option>
                                @endforeach
                              
                            </select>
                          </div>
                     </div>

                     <div class="item form-group">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="cant_disp" class="form-control has-feedback-left" name="cant_disp" type="number" title="Megas disponibles para soluciones de aplicación seleccionada" readonly>
                        <span class="fa fa-pie-chart form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input id="cant_asign" class="form-control has-feedback-left" name="cant_asign" type="number" title="Megas a asignar para solución" onchange="alertMsg();" required value=0>
                        <span class="fa fa-pie-chart form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     </div>


                          <div class="item form-group">
                             @if (Session::has('loginrfcerr'))
                                    <span class="help-block">
                                        <strong>{{ Session::pull('loginrfcerr') }}</strong>
                                    </span>
                            @endif
                          </div>

                          

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button" onclick="location.href = '{{ URL::to('apps') }}';">Cancelar</button>
                          <button type="submit" class="btn btn-success" onclick="commit()">Generar</button>
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

      <script>
      function showWaitingModal()
      {
        $('#loadingmodal').modal('show');
      }

          $( function() {
              $('#alertmsgcreation').click(function() {
                  console.log('alertmsgcreation button clicked');
              });
              
             setTimeout(function() {
                  $('#alertmsgcreation').trigger('click');
              }, 4e3);
          });
     
          $('#emps').trigger('change');

          function filldata() {
          var dataapps = [];
          var dataemps = [];
          var apps =jQuery.parseJSON(document.getElementById('apps').value);
          var emps =jQuery.parseJSON(document.getElementById('emps').value);
          
          if (emps.length > 0) {
            
            for (var i = 0; i < emps.length; i++) {
              var dice = {'id': emps[i].id, 'text': emps[i].empr_nom};
              dataemps.push(dice);
            }

            console.log(dataemps);

            $("#bdapp_empr_id").select2({
                  placeholder: 'Seleccione una empresa...',
                  allowClear: true,
                  //data: dataemps
               });
          }

          if (apps.length > 0) {
            for (var i = 0; i < apps.length; i++) {
              var dic = {'id': apps[i].id, 'text': apps[i].app_nom};
              dataapps.push(dic);
            }
          }

          $("#bdapp_app_id").select2({
                  //data: dataapps,
                  allowClear: true,
                  placeholder: 'Seleccione una aplicación...'
                   
               });
        }

        function showMegasDisp(select)
        {
          var appid = document.getElementById("bdapp_app_id").value;
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

             console.log(CSRF_TOKEN);

             $.ajax({
                url: 'getespdisp',
                type: 'POST',
                data: {_token: CSRF_TOKEN,appid:appid},
                dataType: 'JSON',
                success: function (data) {
                  console.log(data['megdisp']);
                  if (data['status'] == 'success')
                  {
                    console.log(data['megdisp']);
                    $('#cant_disp').value = data['megdisp'];
                  }

                }
            });
        }

        function checkCantAsign(cantAsign, cantDisp)
        {
           
           if (cantDisp)
           {
            if (cantAsign >= cantDisp)
            {
              return false;
            }
           }
           return true;
        }

        function alertMsg()
        {
          var cantAsign = document.getElementById('cant_asign').value;
          var cantDisp = document.getElementById('cant_disp').value;

          var checkCant = checkCantAsign(cantAsign, cantDisp);
          if (checkCant == false)
          {
            alert('No puede asignar una cantidad superior a la disponible');
            $('#cant_asign').value = 0;
          }
          
        }

        function commit()
        {
          var cantAsign = document.getElementById('cant_asign').value;
          var cantDisp = document.getElementById('cant_disp').value;

          var checkCant = checkCantAsign(cantAsign, cantDisp);
          if (checkCant == false)
          {
            alert('No puede asignar una cantidad superior a la disponible');
          }
          else if(cantAsign == 0 && cantDisp > 0)
          {
            alert('Debe asignar un espacio para solución a crear');
          }
          else
          {
            showWaitingModal();
          }
          
        }

      </script>

@endsection
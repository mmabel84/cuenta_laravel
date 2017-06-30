 @extends('admin.template.main')


@section('app_title')
      Aplicaciones
@endsection 

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
	                    <button id="alertmsgcreation" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	                    </button>
	                    <strong>{{ Session::get('message') }}</strong>
	                  </div>
                  @endif
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('apps.store')}}">
                    {{ csrf_field() }}


                    <input type="hidden" id="apps" name="apps" value="{{ $aplicaciones }}">

                    <div class="form-group">
                        <!--<label class="control-label col-md-3 col-sm-3 col-xs-12">Aplicación</label>-->
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="js-example-data-array form-control" tabindex="-1" name="bdapp_app_id" id="bdapp_app_id">
                               <!--<option value="null">Seleccione una aplicación ...</option>
                                @foreach($aplicaciones as $app)
                                    <option value="{{ $app->id }}">{{ $app->app_nom }}</option>
                                @endforeach-->
                              
                            </select>
                          </div>
                     </div>

                     
                     <input type="hidden" id="emps" name="emps" value="{{ $empresas }}" onchange="filldata();">
	                      <div class="form-group">
	                          <div class="col-md-9 col-sm-9 col-xs-12">
	                             <select class="js-example-data-array form-control" tabindex="-1" name="bdapp_empr_id" id="bdapp_empr_id">
		                            <!--<option value="null">Seleccione una empresa ...</option>
		                            @foreach($empresas as $empr)
		                                <option value="{{ $empr->id }}">{{ $empr->empr_nom }}</option>
		                            @endforeach-->
		                          </select>
	                          </div>
	                        </div>

	                      <!--<div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre de servidor <span class="required">*</span>
	                        </label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input type="text" id="bdapp_nomserv" name="bdapp_nomserv" required="required" class="form-control col-md-7 col-xs-12">
	                        </div>
	                      </div>-->

	                       
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button" onclick="location.href = '{{ URL::to('apps') }}';">Cancelar</button>
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
          $( function() {
              $('#alertmsgcreation').click(function() {
                  console.log('alertmsgcreation button clicked');
              });
              
             setTimeout(function() {
                  $('#alertmsgcreation').trigger('click');
              }, 4e3);
          });
      </script>



      <script type="text/javascript">
          
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
                  data: dataemps,
                  allowClear: true,
                  placeholder: 'Seleccione una empresa...'
                   
               });

                         
          }
          

          if (apps.length > 0) {
            for (var i = 0; i < apps.length; i++) {
              var dic = {'id': apps[i].id, 'text': apps[i].app_nom};
              dataapps.push(dic);
            }

            $("#bdapp_app_id").select2({
                  data: dataapps,
                  allowClear: true,
                  placeholder: 'Seleccione una aplicación...'
                   
               });

                         
          }


        }

           

          

        </script>


@endsection
 @extends('admin.template.main')


@section('app_css')
        @parent
        
  	   <!-- Switchery -->
    <link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.css') }}" rel="stylesheet">
    <!-- Datetime -->
    <link href="{{ asset('vendors/datetime/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">
    <!-- Chosen -->
    <link href="{{ asset('vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select 2 -->
    <link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet">

	    	
@endsection 

@section('content')
	
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Crear respaldo aplicación</h2>
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
                    <form id="form2" class="form-horizontal form-label-left" novalidate method="POST" action="{{route('backups.store')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" id="apps" name="apps" value="{{ $bdapp }}" onchange="filldata();">
                    <div class="item form-group">
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="js-example-basic-single js-states form-control" name="bdapp_app_id" id="bdapp_app_id" required title="Solución">
                                <option value="">Seleccione una solución...</option>
                                @foreach($bdapp as $bd)
                                    <option value="{{ $bd->id }}">{{ $bd->empresa->empr_nom }} {{ $bd->aplicacion->app_nom }}</option>
                                @endforeach
                              
                            </select>
                          </div>
                     </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button" onclick="location.href = '{{ URL::to('backups') }}';">Cancelar</button>
                          <button type="submit" class="btn btn-success" onclick="showWaitingModal()">Generar</button>
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
    <!-- Chosen -->
    <script src="{{ asset('vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
    <!-- validator -->
    <script src="{{ asset('vendors/validator/control.validator.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.js') }}"></script>
    <!-- Date Time -->
    <script type="text/javascript" src="{{ asset('vendors/datetime/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('vendors/datetime/js/locales/bootstrap-datetimepicker.es.js') }}" charset="UTF-8"></script>
    <!-- Select 2 -->
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>

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
      </script>


      <script type="text/javascript">
          
          $('#apps').trigger('change');

          function filldata() {
          
          var dataapps = [];
          var apps =jQuery.parseJSON(document.getElementById('apps').value);
          console.log(apps);

                      
            $("#bdapp_app_id").select2({
                  allowClear: true,
                  placeholder: 'Seleccione una solución...'
                   
               });
        }
        </script>

		@endsection 

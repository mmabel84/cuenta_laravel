 @extends('admin.template.main')


@section('app_title')
      Respaldos
@endsection 


@section('app_css')
        @parent
        <!-- Forms -->
	        
	    	<link href="{{ asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/starrr/dist/starrr.css') }}" rel="stylesheet">

	    	<link href="{{ asset('vendors/cropper/dist/cropper.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/normalize-css/normalize.css" rel="stylesheet') }}" rel="stylesheet">
	    	
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
                    <form id="form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('backups.store')}}">
                    {{ csrf_field() }}

                    <input type="hidden" id="apps" name="apps" value="{{ $bdapp }}" onchange="filldata();">
                    <div class="form-group">
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="js-example-data-array form-control" tabindex="-1" name="bdapp_app_id" id="bdapp_app_id">
                                @foreach($bdapp as $bd)
                                    <option value="{{ $bd->id }}">{{ $bd->empresa->empr_nom }} {{ $bd->aplicacion->app_nom }}</option>
                                @endforeach
                              
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
                          <button class="btn btn-primary" type="button">Cancelar</button>
						  <button class="btn btn-primary" type="reset">Limpiar</button>
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
        <!-- Forms -->

	    	<script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
	    	<script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
	    	<script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
	    	<script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	    	<script src="{{ asset('vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
	    	<script src="{{ asset('vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
	    	<script src="{{ asset('vendors/google-code-prettify/src/prettify.js') }}"></script>
	    	<script src="{{ asset('vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
	    	<script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>
	    	<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js') }}"></script>
	    	<script src="{{ asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
	    	<script src="{{ asset('vendors/autosize/dist/autosize.min.js') }}"></script>
	    	<script src="{{ asset('vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>
	    	<script src="{{ asset('vendors/starrr/dist/starrr.js') }}"></script>
	    	<script src="{{ asset('vendors/starrr/dist/starrr.js') }}"></script>

	    	<script src="{{ asset('vendors/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
	    	<script src="{{ asset('vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
	    	<script src="{{ asset('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
	    	<script src="{{ asset('vendors/jquery-knob/dist/jquery.knob.min.js') }}"></script>
	    	<script src="{{ asset('vendors/cropper/dist/cropper.min.js') }}"></script>
	    	<script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
	    	<script src="{{ asset('build/js/custom.js') }}"></script>

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
          
          $('#apps').trigger('change');

          function filldata() {
          
          var dataapps = [];
          var apps =jQuery.parseJSON(document.getElementById('apps').value);
          console.log(apps);

                      
            $("#bdapp_app_id").select2({
                  allowClear: true,
                  placeholder: 'Seleccione una aplicación...'
                   
               });


        }
        </script>


	    		      
		@endsection 

@extends('admin.template.main')

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

	    		      
		@endsection 



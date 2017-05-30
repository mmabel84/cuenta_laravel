@extends('admin.template.main')

        @section('formjs')
        <!-- Forms -->
	        <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/starrr/dist/starrr.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

	    	<link href="{{ asset('vendors/cropper/dist/cropper.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/normalize-css/normalize.css" rel="stylesheet') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

	    	



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

	    	<!-- Tables -->
	    	<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
	    	<link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

	    	<script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
	    	<script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
	    	<script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
	    	<script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
	    	<script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>

	      
		@endsection 



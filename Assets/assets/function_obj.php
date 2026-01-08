<script >
	function export_datatable(id){	
			$('#'+id).DataTable( {  
			scrollCollapse: true,   
		    /*"scrollX": true,*/
		    dom: 'Bfrtip',
			  buttons: [
			  {
			   extend: "excel",
			    className: "btn bg-green btn-circle waves-effect waves-circle waves-float waves-light",
			    titleAttr: 'Export in Excel',
			    text:'xls', /*'<i class="fa fa-file-excel-o"></i>',*/
			    init: function(api, node, config) {
			       $(node).removeClass('btn-default')
			    }
			  },
			  {
			    extend: "csv",
			    className: "btn bg-orange btn-circle waves-effect waves-circle waves-float waves-light",
			    titleAttr: 'Export in CSV',
			    text: '<i class="material-icons">content_copy</i>',/*'<i class="fa  fa-file-text-o"></i>',*/
			    init: function(api, node, config) {
			       $(node).removeClass('btn-default')
			    }
			  },
			  {
			    extend: "pdf",
			    className: "btn bg-red btn-circle waves-effect waves-circle waves-float waves-light",
			    titleAttr: 'Export in PDF',
			    text: '<i class="material-icons">picture_as_pdf</i>',/*'<i class="fa  fa-file-pdf-o"></i>',*/
			    init: function(api, node, config) {
			       $(node).removeClass('btn-default')
			    }
			  },
			  {
			    extend: "copy",
			    className: "btn bg-brown btn-circle waves-effect waves-circle waves-float waves-light",
			    titleAttr: 'Coppy Data',
			    text: '<i class="material-icons">local_cafe</i>',/*'<i class="fa fa-coffee"></i>',*/
			    init: function(api, node, config) {
			       $(node).removeClass('btn-default')
			    }
			  }
			  ]
			  } );
		}
		function tabel2(id){
			$('#'+id).DataTable();
		}
		function tabel3(id){
			$('#'+id).DataTable( {
		        scrollY:        '50vh',
		        scrollCollapse: true,
		        paging:         false
		    } );
		}
		function select2(id){
			$('#'+id).select2({theme: "classic"});
		}
		function daterange(id){
			$('#'+id).daterangepicker(); 
		}
		function datetimerange(id){
			$('#'+id).daterangepicker({
			    timePicker: true,
			    startDate: moment().startOf('hour'),
			    endDate: moment().startOf('hour').add(32, 'hour'),
			    locale: {
			      format: 'M/DD/YYYY HH:mm:ss'
			    }
			  });
		}
		function datepicker(id){
			$('#'+id).datepicker({
		      autoclose: true
		    });
		}
		function timepicker(id){
			$('#'+id).timepicker({
		      showInputs: false
		    });
		}
		function textarea(id){
			$('#'+id).wysihtml5();
				
		}
	
</script>
<script>
$(document).ready(function() {
    $('.table-export').DataTable( {   
    "scrollX": true,
    dom: 'Bfrtip',
  buttons: [
  {
   extend: "excel",
    className: "btn bg-olive btn-flat margin",
    titleAttr: 'Export in Excel',
    text: '<i class="fa fa-file-excel-o"></i>',
    init: function(api, node, config) {
       $(node).removeClass('btn-default')
    }
  },
  {
    extend: "csv",
    className: "btn bg-orange btn-flat margin",
    titleAttr: 'Export in CSV',
    text: '<i class="fa  fa-file-text-o"></i>',
    init: function(api, node, config) {
       $(node).removeClass('btn-default')
    }
  },
  {
    extend: "pdf",
    className: "btn bg-red btn-flat margin",
    titleAttr: 'Export in PDF',
    text: '<i class="fa  fa-file-pdf-o"></i>',
    init: function(api, node, config) {
       $(node).removeClass('btn-default')
    }
  },
  {
    extend: "copy",
    className: "btn bg-navy btn-flat margin",
    titleAttr: 'Coppy Data',
    text: '<i class="fa fa-coffee"></i>',
    init: function(api, node, config) {
       $(node).removeClass('btn-default')
    }
  }
  ]
  } );
  
} );

  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2({theme: "classic",dropdownAutoWidth : true,
    width: 'auto'});
	$('.daterange').daterangepicker(); 
  $('.datetimerange').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'M/DD/YYYY HH:mm:ss'
    }
  });
	$(".tabel2").DataTable();
	 $('.datepicker').datepicker({
      autoclose: true
    });
    $(".timepicker").timepicker({
      showInputs: false
    });
	$(".textarea").wysihtml5();
	 });
</script>
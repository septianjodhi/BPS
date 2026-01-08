
<script>
	$(function() {
		$('input[name="rg_tgl"]').daterangepicker({
			opens: 'left'
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});

	$(document).ready(function()
	{

		$('.periodemn').bootstrapMaterialDatePicker({
			format: 'YYYYMM', minDate : new Date(),
			clearButton: true,
			weekStart: 0,
			time: false
		});	
		$('.periodeflex').bootstrapMaterialDatePicker({
			format: 'YYYYMM',
			clearButton: true,
			weekStart: 0,
			time: false
		});	
	});
	function open_childX(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
</script>

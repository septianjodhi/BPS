
<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
	function pil_add(){
		$("#list_part").html('');
		var lstctrl=document.frmcari.noctrlplh.value;
		if(lstctrl==""){
			alert('ANDA BELUM MEMILIH DATA');
		}else
		{
			jQuery.ajax({
			type: 'GET', // Post / Get method
			url: 'select/list_noctrl_inv.php',
			dataType:"text", 
			data: {'ctrl':lstctrl,'sesi':'<?php echo $_SESSION['lok']; ?>'}, 
			success:function(response){
				$("#list_part").append(response);
				$('#mdplhpr').modal('show');
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}
		});
		}
	};
</script>


		<script type="text/javascript">
			function dipilih(frm){
				var PlhData="";
				var PchData="";
				var data0="";
				var data1="<?php echo $row; ?>";
				if(data1==1){
					data0 += "<?php echo $no_ctrl_p; ?>,";
				}else{
					for (i = 0; i < frm.plh.length; i++){
						if (frm.plh[i].checked){
				//PlhData += frm.plh[i].value +",";
				var dataisi=frm.plh[i].value;
				PchData=dataisi.split('|');
				data0 += PchData[0] +",";
			}else{	
			}	
		}
	}
	document.frmcari.noctrlplh.value=data0;
}	

function pilih(row){
	var kd_pel4=row.cells[3].innerHTML;
	alert(kd_pel4);
}

$(document).ready(function()
{
	$('.periodemn').bootstrapMaterialDatePicker({
		format: 'YYYYMM', minDate : new Date(),
		clearButton: true,
		weekStart: 0,
		time: false
	});	
	$('.date_req').bootstrapMaterialDatePicker({
		format: 'YYYY-MM-DD',
		clearButton: true,
		weekStart: 0,
		time: false
	});	
});

function sum() {
	var txtFirstNumberValue=document.frmcari.qty_cip.value;
	var txtSecondNumberValue=document.frmcari.price_g.value;
	var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
	if (!isNaN(result)) {
		document.getElementById('amount').value = formatMoney(result);
	}
}
</script>
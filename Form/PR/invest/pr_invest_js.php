<?php
$pngloding="././dist/img/wait-bulat.png";
$sect= $_SESSION["area"];
$pic=$_SESSION["nama"];

?>


<script >
$(document).ready(function() {
	view_pr();
    $('#frmcariinvest').on('submit', function(event){
        event.preventDefault(); 
        $('#loding').after('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>'); 
       $.ajax({  
              url:'form/pr/invest/tbl_inptpr.php',
              method:"POST",  
              data:new FormData(this),  
              contentType:false,  
              processData:false,
              success:function(data){   
                $('#buatpr').html(data);                 
                $('.loading').remove();
                
             },
             error:function(data){
              alert("Gagal Proses Data");
             
            }

          }); 
    });
     $('#frm_svpr').on('submit', function(event){
        event.preventDefault(); 
        $('#frm_svpr').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>'); 
        var proses="";
       proses=save_pr();
       alert(proses); 
       if(proses !=""){
       		finish_pr(proses);
       		view_pr();
       		$('#mdplhpr').modal("hide");
       		$('#buatpr').html('');
       }               
        $('.loading').remove();
    });
$('.date_req').bootstrapMaterialDatePicker({
		format: 'YYYY-MM-DD',
		minDate : new Date(),
		clearButton: true,
		weekStart: 0,
		time: false
	});	

})   
function listperi(){
	var cip=$('#dt_phs').val();
	$("#peri").html('');
	$("#curr").html('');
	$('#buatpr').html(''); 
	if(cip !="" ){
	$('#loding').after('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
	 $.ajax({
			method: 'post',
			data: {"cip":cip} ,
			        url: 'form/pr/invest/ls_periode.php',
			        cache: true,
                    //contentType:false,  
                  //  processData:false,
			        success: function(data) {	
			           $("#peri").append(data);
			           $('.loading').remove();	
			          // alert("OK");
			        }
			    });
	}
}
function listcurr(){
	var cip=$('#dt_phs').val();
	var peri=$("#peri").val();
		$("#curr").html('');
	$('#buatpr').html('');
	if(cip !="" && peri !=""){
		$('#loding').after('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
		$.ajax({
			method: 'post',
			data: {"cip":cip,"peri":peri} ,
			        url: 'form/pr/invest/ls_curr.php',
			        cache: true,
                    //contentType:false,  
                  //  processData:false,
			        success: function(data) {	
			           $("#curr").append(data);
			           $("#loading").html(data);
			           $('.loading').remove();	
			          // alert("OK");
			        }
			    });
	}
}
function cari_header() {
	var hasil="";
	var d=new Date();
  	var wkt = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);

	var sect="<?=$sect;?>";
	/*var wkt="<?= date("Y-m-d H:i:s");?>";*/
	var pic="<?=$pic;?>";
	var noprinv="";
	var kd_dept="";
	var baris=document.getElementById("jumbar").innerHTML;  
	var pertama=0;
	var amountpilih=0;
	var sisabud=0;
	var tabelpilih = $('#terpilih').DataTable();
	var totbud=0;
	var totpr=0;
	tabelpilih.clear().draw();	
	for (var i = 1; i <=baris; i++) {
        var jumbar=tabelpilih.rows().count() + 1;
  		var ck=document.getElementById("kola_"+i).checked;
	  	var kola=document.getElementById("kola_"+i).value;
	//alert(kola+" - "+ck);
  		if(ck==true){
  		pertama++;
  		if(pertama==1){	
  			$.ajax({
			method: 'post',
			data: {"s":sect,"c":wkt,"p":pic,"k":kola} ,
			        url: 'form/pr/invest/ls_headerpr.php',
			        cache: false,
			        async:false,
                    //contentType:false,  
                  //  processData:false,
			        success: function(data) {
			        hasil=data;	
			         //  $("#loading").after(data);
			        //   alert(data);
		           const obj = JSON.parse(data);
			           noprinv=obj.list[0].nopr;
			           kd_dept=obj.list[0].kode_departement;
			           sisabud=obj.list[0].sisabudget;
			           totbud=obj.list[0].totalbudget;;
					    totpr=obj.list[0].totalpr;;
			        }
			    });
  		}

	  		var kolb=document.getElementById("kolb_"+i).innerHTML;
	  		var kolc=document.getElementById("kolc_"+i).innerHTML;
	  		var kold=document.getElementById("kold_"+i).innerHTML;
	  		var kole=document.getElementById("kole_"+i).innerHTML;
	  		var kolf=document.getElementById("kolf_"+i).innerHTML;
	  		var kolg=document.getElementById("kolg_"+i).innerHTML;
	  		var kolh=document.getElementById("kolh_"+i).value;
	  		var koli=document.getElementById("koli_"+i).innerHTML;
	  		var kolj=document.getElementById("kolj_"+i).value;
	  		var kolk=document.getElementById("kolk_"+i).innerHTML;
	  		amountpilih=amountpilih+(parseFloat(kolh.replace(/,/g, ""))*parseFloat(kolj.replace(/,/g, "")));
	//alert(amountpilih);
  	tabelpilih.row.add([ jumbar, kolb,kolc,kold,kole,kolf,kolg,kolh,koli,kolj,kolk]).draw();
  		}
  	}  
  	//	alert(sisabudget);
  	var pesan_salah="<ul><li>Total Budget invest "+ totbud +"</li><li>Sudah dibuat PR " + totpr + "</li><li>Sisa Budget Sebelumnya " + sisabud + "</li><li>Kebutuhan saat ini " + amountpilih + "</li><li>Sisa Akhir " + (sisabud-amountpilih) + "</li></ul>";
  if((sisabud-amountpilih) >0){
  	
  	document.getElementById("timecreate").value=wkt;
	document.getElementById("prno").value=noprinv; 
	document.getElementById("kddep").value=kd_dept;  
	$('#mdplhpr').modal("show");
	}else{
		alert("Budget tidak mencukupi <br> " + pesan_salah);
	}
}
function save_pr(){
	var sect="<?=$sect;?>";
	var wkt=document.getElementById("timecreate").value; //"<?= date("Y-m-d H:i:s");?>";
	var pic="<?=$pic;?>";
	var noprinv=document.getElementById("prno").value; 
	var kd_dept=document.getElementById("kddep").value;
	var rmk_pr=document.getElementById("rmk_pr").value;
	var tg_pr=document.getElementById("pr_date").value;
	var tg_eta=document.getElementById("req_date").value;
	var baris=document.getElementById("jumbar").innerHTML;  
	var pertama=0;
	var kodepr="";
for (var i = 1; i <=baris; i++) {
  		var kola=document.getElementById("kola_"+i).value;
  		var ck=document.getElementById("kola_"+i).checked;
  		var q_ord=document.getElementById("kolj_"+i).value;
  		if(ck==true){
  		pertama++;
			if(noprinv !=""){
  		//	alert(kola+" - "+ck);
				$.ajax({
			method: 'post',
			data: {"s":sect,"c":wkt,"p":pic,"no":pertama,"k":kola,"kddep":kd_dept,"nopr":noprinv,"qty":q_ord,"tgpr":tg_pr,"tgeta":tg_eta,"rmkpr":rmk_pr} ,
			        url: 'form/pr/invest/sv_dtl_inptpr.php',
			        cache: true,
			        async:false,
                    //contentType:false,  
                  //  processData:false,
			        success: function(data) {	
			          // $("#buatpr").after(data);
			           const obj = JSON.parse(data);
			           //noprinv=obj.list[0].cari_bud;
			           kodepr=obj.list[0].kodepr;
					//	alert(obj.list[0].cari_bud);	
			        }
			    });
			}
		}
	} 
	return kodepr;
}
function finish_pr(kdpr){
	var pic="<?=$pic;?>";
	var sect="<?=$sect;?>";
	var rmk_pr=document.getElementById("rmk_pr").value;
	var noprinv=document.getElementById("prno").value; 
		$.ajax({
			method: 'post',
			data: {"kp":kdpr,"p":pic,"s":sect,"rmkpr":rmk_pr,"nopr":noprinv} ,
			        url: 'form/pr/invest/sv_dok_inptpr.php',
			        cache: true,
                    //contentType:false,  
                  //  processData:false,
			        success: function(data) {	
			           alert(data);
			        }
			    });
	
}
function view_pr(){
	var sect="<?=$sect;?>";
		$.ajax({
			method: 'post',
			data: {"s":sect} ,
			        url: 'form/pr/invest/tbl_prnpr.php',
			        cache: true,
                    //contentType:false,  
                  //  processData:false,
			        success: function(data) {
			        $('#tbldata').html(data);	
			          // alert(data);
			        }
			    });
	
}
</script>
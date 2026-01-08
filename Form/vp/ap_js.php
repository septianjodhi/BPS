<?php
$pngloding="images/wait-bulat.png";
$sect= $_SESSION["area"];
$pic=$_SESSION["nama"];

?>
<script >
	showmodal_ap();
$(document).ready(function() {
    $('#frm_sendap').on('submit', function(event){
        event.preventDefault(); 
        $('#sendap').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>'); 
       $.ajax({  
              url:'form/vp/send_ap.php',
              method:"POST",  
              data:new FormData(this),  
              contentType:false,  
              processData:false,
              success:function(data){   
                $('#tbldata').html(data);     
                //alert('Sukses');            
                $('#mdplhvp').modal('hide');
                $('.loading').remove();
                
             },
             error:function(data){
              alert("Gagal Proses Data");
             
            }

          }); 
    });
      $('#frm_upldvp').on('submit', function(event){
        event.preventDefault(); 
        $('#sendap').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>'); 
       $.ajax({  
              url:'form/vp/send_apnonvp.php',
              method:"POST",  
              data:new FormData(this),  
              contentType:false,  
              processData:false,
              success:function(data){   
                $('#tbldata').html(data);     
                //alert('Sukses');            
                $('#mdupldvp').modal('hide');
                $('.loading').remove();
                
             },
             error:function(data){
              alert("Gagal Proses Data");
             
            }

          }); 
    });
    $('#frm_crap').on('submit', function(event){
        event.preventDefault(); 
        $('#frm_crap').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>'); 
       $.ajax({  
              url:'form/vp/tbl_ap.php',
              method:"POST",  
              data:new FormData(this),  
              contentType:false,  
              processData:false,
              success:function(data){   
                $('#tbldata').html(data); 
                $('.loading').remove();
                
             },
             error:function(data){
              alert("Gagal Proses Data");
             
            }

          }); 
    });
   
    })  
function showmodal_ap(){
var trm='<?=$termnow;?>';
var sect="<?=$sect;?>";
$('#loding').after('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
 	$.ajax({
		method: 'post',
		data: {"term":trm,"sec":sect} ,
		url: 'form/vp/ls_pervpo.php',
		cache: false,
       // contentType:false,  
        //  processData:false,
		success: function(data) {
			//$("select[id='pervp_o']").find('option').remove().end().append($(data));
			$('#pervp_o').html(data); 			
			//alert(trm);
			$('#pervp_o').selectpicker();
			//$('#mdplhvp').modal('show');
			 $('.loading').remove();	
		}
	});

}
function list_peri(){
var trmx=$('#ap_term').val();
var sect="<?=$sect;?>";
$('#loding').after('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
	//		alert(trmx);
 	$.ajax({
		method: 'post',
		data: {"term":trmx,"sec":sect} ,
		url: 'form/vp/ls_pervpo.php',
		cache: false,
        //contentType:false,  
        //processData:false,
		success: function(data) {	
			//$("select[id='ap_peri']").find('option').remove().end().append($(data));
			$('#ap_peri').html(data);	
			 $('#ap_peri').selectpicker();
			 $('.loading').remove();	
		},
	});

}

function listvp_open(){
	var trm="<?= $termnow;?>";
	var periode=$('#pervp_o').val();
	//alert(periode);
	$('#pervp_o').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
	 $.ajax({
			method: 'post',
			data: {"term":trm,"peri":periode} ,
			        url: 'form/vp/ls_vpo.php',
			        cache: false,
                   // contentType:false,  
                    //processData:false,
			        success: function(data) {	
			         // $("select[id='vp_o']").find('option').remove().end().append($(data));
			          $('#vp_o').html(data);
			          $('#vp_o').selectpicker();
			           $('.loading').remove();	
			          // alert("OK");
			        }
			    });
}
function hapus_ap(vpno){
	//alert(periode);
	$('#pervp_o').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
	 $.ajax({
			method: 'post',
			data: {"vp":vpno} ,
			        url: 'form/vp/delvp.php',
			        cache: false,
                   // contentType:false,  
                    //processData:false,
			        success: function(data) {	
			          $('#tbldata').html(''); 
			           $('.loading').remove();	
			          // alert("OK");
			        }
			    });
}
</script>
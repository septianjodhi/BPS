<?php
$pngloding="././dist/img/wait-bulat.png";
$sect= $_SESSION["area"];
$pic=$_SESSION["nama"];
$lokasii=$_SESSION["lokasi"];

?>
<script >
$(document).ready(function() {
    $('#frm_importsupp').on('submit', function(event){
        event.preventDefault(); 
        $('#frm_importsupp').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>'); 
       $.ajax({  
              url:'form/supplier/import_suppfa.php',
              method:"POST",  
              data:new FormData(this),  
              contentType:false,  
              processData:false,
              success:function(data){   
				var kolom='pic_update';
			    var detail='<?=$pic;?>';			        	
			    cr_suppfa(kolom,detail);           
                $('#mdimportxls').modal('hide');
                $('.loading').remove();
                
             },
             error:function(data){
              alert("Gagal Proses Data");
             
            }

          }); 
    });
    $('#frm_crsupp').on('submit', function(event){
        event.preventDefault(); 
        var kolom=$('#cmd_cari').val();
        var isi=$('#txt_cari').val();
        cr_suppfa(kolom,isi);
    });

    })  


function show_modimport(){
	$('#mdimportxls').modal('show');
}
function cr_suppfa(kolom,detail){
	$('#tbldata').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
	 $.ajax({
			method: 'post',
			data: {"cmd_cari":kolom,"txt_cari":detail} ,
			        url: 'form/supplier/tbl_suppfa.php',
			        cache: false,
                   // contentType:false,  
                    //processData:false,
			        success: function(data) {	
			          $('#tbldata').html(data);
			           $('.loading').remove();	
			          // alert("OK");
			        }
			    });
}
function hapus_suppfa(kodesupp,id_suppsite){
	//alert(periode);
	$('#tbldata').before('<span class="loading" align="center"><img alt="loading..." src="<?=$pngloding;?>" /></span>');
	 $.ajax({
			method: 'post',
			data: {"kode":kodesupp,"idss":id_suppsite} ,
			        url: 'form/supplier/delsupfa.php',
			        cache: false,
                   // contentType:false,  
                    //processData:false,
			        success: function(data) {	
			        //  $('#tbldata').html(''); 
			        	var kolom=$('#cmd_cari').val();
			        	var detail=$('#txt_cari').val();			        	
			        	cr_suppfa(kolom,detail);
			           $('.loading').remove();	
			          // alert("OK");
			        }
			    });
}
</script>
<style>
.my-custom-scrollbar {
position: relative;
height: 400px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>
<script>

function open_childX(url,title,w,h){
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);
		
  };	
function pil_add(){
	$("#list_part").html('');
var lstctrl=document.frmcari.plh.value;
if(lstctrl==""){alert('ANDA BELUM MEMILIH DATA');}else{
		jQuery.ajax({
			type: 'GET', // Post / Get method
			url: 'select/list_part.php',
			dataType:"text", 
			data: {'part':lstctrl},
			success:function(response){
				$("#list_part").append(response);
				$('#mdplhpo').modal('show');
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}
			});
}	
};
</script>
<?php
$sect=$_SESSION["area"]; 
$pic=$_SESSION["nama"];
	$pch_sect=explode("-",$sect);
	$dept=$pch_sect[0];
	$sec=$pch_sect[1];


if(isset($_POST['smpn_po']) ){
	
	$bln=date("Ym");
	$nopo=0;
	$plh=$_POST['plh'];
	$kd_spp=$_POST['suppl'];
	$eta=$_POST['eta_po'];
	
	//$qry_nopo="select max(RIGHT(po_no,3)) as jj from bps_podtl where lp='$sect' and convert(nvarchar(6),tgl_updt,112)='$bln'";
	$qry_nopo="select max(RIGHT(po_no,3)) as jj from bps_podtl where lp='$pch_sect[1]' and kode_supp='$kd_spp' and convert(nvarchar(6),tgl_updt,112)='$bln'";
	//periode='$per_tmp'";
	$tb_nopo=odbc_exec($koneksi_lp,$qry_nopo);
	while($bar_nopo=odbc_fetch_array($tb_nopo)){
		$nopo=odbc_result($tb_nopo,"jj");
	}
$nopo=$nopo+1;	
$nopo3=substr('000'.$nopo,-3);
//$po_date=$_POST["po_date"];
//$po_no=$pch_sect[1]."-".$np2[1]."-".date("ym",strtotime(now))."-".$nopo3;

$po_no="PO-".$sec."-".$kd_spp.$bln."-".$nopo3;
foreach ($plh as $_boxValue2){
$np2=explode("|",$_boxValue2);
//$po_no="PO-".$sec."-".$np2[1].$bln."-".$nopo3;
//$po_no=$np2[0].".".date("ym",strtotime(now))."-".$nopo3;
//===================================================================================================
$del="delete from bps_podtl where po_no='0' and kode_supp='".$np2[1]."' and part_no='".$np2[0]."' and pr_no='".$np2[2]."' and lp='$sec'";
$tb_del=odbc_exec($koneksi_lp,$del);

$qryinpodtl="insert into bps_podtl ( no_quo, pr_no, kode_supp, part_no, part_nm, part_dtl, part_desc,price,lp ,po_no ,pic_updt,tgl_updt, qty, term, periode,curr,uom,eta,status_po)
select distinct no_quo,pr_no,kode_supp,part_no,part_nm,part_dtl,part_desc,price_tot as price,lp,'$po_no' as po_no,'$pic' as pic_updt,getdate() as tgl_updt,sum(qty_act) as qty,term,periode,curr,uom,'$eta' as eta,'OPEN' as status_po from bps_tmpPR where kode_supp='".$np2[1]."' and part_no='".$np2[0]."' and pr_no='".$np2[2]."' group by no_quo,pr_no,kode_supp,part_no,part_nm,part_dtl,part_desc,price_tot,lp,term,periode,curr,uom";
//$qryinpodtl="update bps_podtl set po_no='$po_no',pic_updt='$pic',tgl_updt=getdate(),eta='$eta',status_po='OPEN' where kode_supp='".$np2[1]."' and part_no='".$np2[0]."' and pr_no='".$np2[2]."'";
$tb_crdtpo=odbc_exec($koneksi_lp,$qryinpodtl);
//echo $qryinpodtl;
}
$qry_delaprv="delete from bps_approve where jns_doc='PO' and no_doc='$po_no'";
$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv) SELECT nama as pic_plan,email as email_plan,'$po_no' as no_doc,getdate() as tgl_prepaire,'PO',sect,initial,approve,no_aprv  FROM bps_setApprove where jns_dok='PO' and (sect='$sect' or sect='$dept-ALL' or sect='SAMI-ALL')";
$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);
//echo $qry_adaprv;
//==================================================================================================
//echo "<script>window.close();</script>";
}

?>	



<section class="content">
<div class="container-fluid">
<div class="block-header">
<h2>Purchase Order</h2>
</div>
	 
<div class="row clearfix">	
<div class="card">
<div class="row clearfix">		
	<div class="header">
	<h2>Record<small>Cari Supplier</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmsupp" method="post"  enctype="multipart/form-data">
	
	<div class="col-sm-3">	
	 <div class="form-group">
	<label>Supplier</label>
	    <div class="form-line">
	  <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="ksupp" id="ksupp" required>
			<option selected="selected" value="">--Pilih Supplier--</option>
			<?php
			$tb_ksupp=odbc_exec($koneksi_lp,"select distinct kode_supp from bps_podtl where po_no='0' ");
while($baris1=odbc_fetch_array($tb_ksupp)){
	$ksupp=odbc_result($tb_ksupp,"kode_supp");
echo '<option value="'.$ksupp.'">'.$ksupp.'</option>';
}
			?>
	  </select>
	  </div> 
    </div></div>

<div class="col-sm-2">
<button type="submit" name="cr_s" id="cr_s" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i> </button>
<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
</div>
</form>
</div>	
</div></div></div>


<?php
if(isset($_POST['cr_s'])){
$kdsuppi=$_POST['ksupp'];
?>
	<div class="row clearfix">
    <div class="card">
    <form action="" id="frmcari" name="frmcari" method="post"  enctype="multipart/form-data">
	
	<div class="row clearfix">				
	<div class="header">
	 <h2>Buat Purchase Order (PO)</h2>
	</div>

	<div class="body">

	<div class="col-sm-2">	
	<div class="form-group">
	<label>Supplier</label>
	<div class="form-line">
	<input type="text" readonly name="suppl" id="suppl" value="<?php echo $kdsuppi; ?>" class="form-control"  required>
    </div></div>
    </div>

	<div class="col-sm-2">	
	<div class="form-group">
	<label>PO Date</label>
	<div class="form-line">
	<input type="text" name="po_date" id="po_date" value="<?php echo date("Y-m-d");?>" class="form-control date-min"  required>
    </div></div>
    </div>
	
	<div class="col-sm-2">	
	<div class="form-group">
	<label>ETA SAMI</label>
	<div class="form-line">
	<input type="text" name="eta_po" id="eta_po" class="form-control date-min"  required>
    </div></div>
    </div> 
	
    </div>	
	</div>
	 
<div class="row clearfix">
<div class="body">
<div class="table-responsive">
<div class="table-wrapper-scroll-y my-custom-scrollbar">
<table id="dtVerticalScroll" class="table table-bordered table-striped dataTable tabel2 " cellspacing="0" width="100%">								
<thead>	
<tr>
<th width="80">Pilih</th>
<th>TERM</th>
<th>PERIODE</th>
<th>SUPP</th>
<th>PR NO</th>
<th>PART NO</th>
<th>PART NAME</th>
<th>PART DETAIL</th>
<th>QTY</th>
<th>PRICE</th>
<th>PO DATE (MIN)</th>
</tr>
</thead>
<tbody>
<?php
//$sq_acc="select distinct term,periode,kode_supp,pr_no,part_no,part_nm,part_dtl,lp,count(kode_supp) as jml_Item,qty_act as qty,curr,price_tot,min(dbo.cr_waktulp('po',no_ctrl)) as min_PO from bps_tmpPR a where penawaran='YES' and no_Quo is not null and exists (select distinct no_doc from bps_approve where jns_doc='PR' and status='FINISH') and a.kode_supp<>'' and not exists (select * from bps_podtl b where b.part_no=a.part_no and b.pr_no=a.pr_no) and kode_supp='$kdsuppi' and lp='$sec' group by a.qty_act, a.kode_supp, a.lp, a.term, a.periode, a.curr, a.pr_no, a.part_no, a.part_nm, a.part_dtl,a.price_tot order by a.part_no";

$sq_acc="select a.term,a.periode,a.kode_supp,a.pr_no,a.part_no,a.part_nm,a.part_dtl,a.part_dtl,a.uom,sum(qty_act) as qty,a.curr,price_tot,min(dateadd(DD,3,pr_date)) as min_po
from bps_tmpPR a inner join bps_podtl b on a.pr_no=b.pr_no and a.part_no=b.part_no and a.lp=b.lp and a.kode_supp=b.kode_supp 
inner join bps_approve c on a.pr_no=c.no_doc 
where po_no='0' and penawaran='YES' and no_aprv=1 and status='FINISH' and a.kode_supp='$kdsuppi' and a.lp='$sec'
group by a.term,a.periode,a.kode_supp,a.pr_no,a.part_no,a.part_nm,a.part_dtl,a.part_dtl,a.uom,a.curr,price_tot order by a.pr_no,a.part_no";


$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
//ECHO $sq_acc;
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ 
$row++;
$supp=odbc_result($tb_acc,"kode_supp");
$part_no=odbc_result($tb_acc,"part_no");
$pr_no=odbc_result($tb_acc,"pr_no"); 
$min_po=date("Y-m-d",strtotime(odbc_result($tb_acc,"min_po")));
$qty=number_format(odbc_result($tb_acc,"qty"),0,".",",");

//$plh="on";$rmx_x="";
//if($tot_prc<$price_quo or $sis_bud<$tot_prc or $act_qty>=($Qadd+$Qplan)){$plh="off";}
//if($ketquo=="YES" and $mount_quo<=0){$plh="off";}
?>	
<tr>				
<td >
<?php //if($plh=="on"){ ?>
<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $part_no.'|'.$supp.'|'.$pr_no.'|'.$qty; ?>" onclick="dipilih(this.form);"><span class="lever"></span></label></div>
<?php //}else{ echo '<i class="material-icons">clear</i>';} ?>
</td>
<td><?php echo odbc_result($tb_acc,"term"); ?></td>
<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
<td><?php echo $supp; ?></td>
<td><?php echo $pr_no; ?></td>
<td><?php echo $part_no; ?></td>
<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
<td><?php echo $qty; ?></td>
<td><?php echo odbc_result($tb_acc,"curr")." ".number_format(odbc_result($tb_acc,"price_tot"),0,".",","); ?></td>
<td><?php echo $min_po; ?></td>
</tr>	
<?php 
}
?>
<tr class="odd gradeX">
<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox" value="-|0|0|0|0|0|0" ></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
<td align="center" valign="middle" nowrap="nowrap"></td>
</tr>

</tbody>
</table>
</div></div>
<button type="submit" id="smpn_po" name="smpn_po" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		
<?php }?>

</div></div>  



<div class="modal fade" id="mdplhpo" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">List Part Dipilih</h4></div>
	<div class="modal-body">
	<div class="body">

		<input type="hidden" class="form-control" id="noctrlplh" name="noctrlplh" required>
		<div id="list_part">		
		</div>
		
	</div>
		  
	<div class="modal-footer">
     <button type="submit" id="smpn_po" name="smpn_po" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>		
	<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
	</div>
</div>
</div></div></div>

		
</form> 
      
</div></div>

<div class="row clearfix">
<div class="card">
<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
<div class="header">
<h2>Print Purchase Order (PO)</h2>
</div>

<div class="row clearfix">
<div class="body">
<div class="table-responsive">
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">						
<thead>
<tr>	
<th>NO</th>
<th>PO NO</th>
<th>TANGGAL</th>
<th>SUPPLIER CODE</th>
<th>SUPPLIER</th>
<th>LP</th>
<th></th>
</tr>
</thead>  
<tbody>
<?php
$sq_po="select distinct a.po_no,min(a.tgl_updt) as tgl,a.kode_supp,b.SUPP_NAME,a.lp from bps_podtl a
inner join lp_supp b on a.kode_supp=b.supp_code where a.lp='$sec' and po_no<> '0' group by a.po_no,a.kode_supp,b.SUPP_NAME,a.lp order by min(a.tgl_updt)";
$tb_po=odbc_exec($koneksi_lp,$sq_po);
$i=0;
while($bar_po=odbc_fetch_array($tb_po)){ $i++;
$pono=odbc_result($tb_po,"po_no");
$supp_code=odbc_result($tb_po,"kode_supp");
?>	
<tr  onclick="javascript:pilih(this);" >
<td><?php echo $i; ?></td>

<!--div class="form-line">
<input type="text" readonly name="pono1[]" id="pono1" value="<?php //echo $pono; ?>" class="form-control"  required></div-->
<td><?php echo $pono; ?></td>
<td><?php echo date("d-M-Y",strtotime(odbc_result($tb_po,"tgl"))); ?></td>
<td><?php echo $supp_code; ?></td>
<td><?php echo odbc_result($tb_po,"SUPP_NAME"); ?></td>
<td><?php echo odbc_result($tb_po,"lp"); ?></td>
<td>
<a href="##"><i onclick="open_child('Exp_pdf/print_po.php?nomor=<?php echo $i;?>&po_no=<?php echo $pono;?>','Print PO <?php echo $pono;?>','800','500'); return false;" class="material-icons">print</i></a>
<a href="#" onClick="deletepo()" ><i  class="material-icons">delete</i></a>
</td>	
</tr>	
				<?php 
}

?>	
</tbody>
</table>
</div></div></div>
</form> 
</div></div>

</div>
</section>

<div class="modal fade" id="mddel" tabindex="1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS PO</h4></div>
<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
	<div class="modal-body">
	APAKAH ANDA YAKIN INGIN MENGHAPUS PO <input type="text" readonly class="form-control" data-role="tagsinput" id="podel" name="podel" placeholder="PO NO" required>
	<div class="modal-footer">
	<button type="submit" id="delpo" name="delpo" class="btn btn-link waves-effect">HAPUS</button>
	<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
	</div>
</form>
</div>
</div></div></div>
<?php
if(isset($_POST['delpo']) ){	
$podel=$_POST["podel"];
//$tb_del1=odbc_exec($koneksi_lp,"delete from bps_podtl where po_no='$pono'");
$tb_del1=odbc_exec($koneksi_lp,"update bps_podtl set po_no='0',status_po=null,eta=NULL where po_no='$pono'");
$tb_del1=odbc_exec($koneksi_lp,"delete from bps_approve where jns_doc='PO' and no_doc='$pono'");
}
?>
<script>
 function dipilih(frm){
		var PlhData="";
		var PchData="";
		var data0="";
		var data1="<?php echo $row; ?>";
		if(data1==1){
			data0 += "<?php echo $part_no.'|'.$supp.'|'.$pr_no.'|'.$qty; ?>,";
		}else{
		for (i = 0; i < frm.plh.length; i++){
			if (frm.plh[i].checked){
				//PlhData += frm.plh[i].value +",";
				var dataisi=frm.plh[i].value;
				//PchData=dataisi.split('|');
				//data0 += PchData[0] +","+PchData[1]+","+PchData[2]+","+PchData[3]+","+PchData[4]+",";
				data0 += dataisi+",";
			}else{
		}
		}
		}
		document.frmcari.noctrlplh.value=data0;
	}	
</script>
 <script>
 function pilih(row){
//alert(row.cells.item(1).innerHTML);
//var kd_pel0=row.cells[0].innerHTML;
var kd_pel1=row.cells[1].innerHTML;
//alert(kd_pel1)
document.frmdel.podel.value=kd_pel1;
 };
function deletepo(){
	$('#mddel').modal('show');
     // window.location.assign('urlkedua')
    };
 </script>
 

 <!--script>
 function pilih(row){
var kd_pel4=row.cells[3].innerHTML;
alert(kd_pel4);
 }
 function kol(kol){

alert(kol+' dari tombol');

var kd_pel1=kol.cells[1].innerHTML;
var icoplus='<i class="material-icons">add_circle</i>';
var icomin='<i class="material-icons">remove_circle</i>';
alert(kd_pel1+icoplus);
if(kd_pel1==icoplus){
kol.cells[1].innerHTML=icomin;
}else{
kol.cells[1].innerHTML=icoplus;}

 }
 </script-->
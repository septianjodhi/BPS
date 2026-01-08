<script>
function open_childX(url,title,w,h){
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);
		
  };	
</script>


<?php $sect= $_SESSION["area"]; 
$pic=$_SESSION["nama"];
$akses=$_SESSION["akses"];
$user=$_SESSION["user"];
$pch_sec=explode("-",$sect);
$whr="and sect='-'";
if(isset($_GET['prv'])){
	switch ($_GET['prv']){
		case 'section':
		$whr="status is null and no_aprv=1 and sect='$sect' and no_doc not like '%FIN%'";break;
		case 'mgr':
		//$whr="status is null and sect='".$pch_sec[0]."-ALL' and pic_plan='$pic' and no_doc in (select no_doc from bps_approve where status='close' and no_aprv=1) and (no_aprv='2' OR no_aprv='3')";break;
		$whr="status is null and pic_plan='$pic' and no_doc in (select no_doc from bps_approve where status='close' and no_aprv<(select min(no_aprv) from bps_approve where pic_plan='$pic')) and no_aprv<4";break;
		case 'verified':
		//$whr="status is null and no_doc in (select no_doc from bps_approve where status='close' and no_aprv=1)";break;
		$whr="status is null and sect='SAMI-ALL' and no_aprv>=4 and pic_plan='$pic' and no_doc in (select no_doc from bps_approve where status='close' and no_aprv<4)";break;
		default :
		$whr="status is null and sect='SAMI-ALL' and pic_plan='$pic'";break;
	}
}
?>
 <section class="content">
 <div class="container-fluid">
	<div class="block-header">
    <h2>APPROVE <?php echo strtoupper($sect); ?></h2>
    </div>
	<div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record Document belum Approve<small>Lihat data Approve</small></h2>
	</div>
	<div class="body">
     <div class="table-responsive">
	 
	 
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
<thead>
<tr>
<th>No Aprv</th>	
<th>Jenis Doc.</th>
<th>Item Doc.</th>	
<th>No Doc.</th>
<th>PIC Plan</th>
<th>Action</th>

</tr>
    </thead>
    <tbody>
<?php
$perinow=date("Ym");
if($_GET['prv']=='verified' and $user='RMU'){
	$sq_acc="SELECT distinct jns_doc,no_doc,'Rofiul Muayati' as pic_plan,'RMU' as initial,4 as no_aprv,'VERIFIED' as approve from bps_approve where status is null and (no_doc in (select no_doc from bps_approve where status='close' and no_aprv=1) or no_doc like '%FIN%') order by jns_doc,no_doc asc";
}else{
$sq_acc="SELECT * from bps_approve where $whr order by no_doc asc";}
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
$jns_doc=odbc_result($tb_acc,"jns_doc");
$no_doc=odbc_result($tb_acc,"no_doc");
$pic_plan=odbc_result($tb_acc,"pic_plan");
$initial=odbc_result($tb_acc,"initial");
$no_aprv=odbc_result($tb_acc,"no_aprv");
//$linkapp="template.php?plh=select/aprv1.php&j=$jns_doc&nd=$no_doc&pp=$pic_plan";
//$linkapp="template.php?plh=select/list_nodoc.php";
				?>	
				<tr  onclick="javascript:pilih(this);" >
<td width="5%"><?php echo /*odbc_result($tb_acc,"no_aprv")*/ $row; ?></td>
<td width="10%"><?php echo $jns_doc; ?></td>
<td width="15%"><?php echo odbc_result($tb_acc,"approve"); ?></td>
<td width="15%"><?php echo $no_doc; ?></td>
<td width="15%"><?php echo $pic; ?></td>
<td>
<button type="button" class="btn bg-green waves-effect" onclick="open_child('select/aprv_<?php echo $jns_doc?>.php?nomor=<?php echo $row;?>&nodoc=<?php echo $no_doc;?>&jnsdok=<?php echo $jns_doc;?>&noaprv=<?php echo $no_aprv;?>&initial=<?php echo $initial;?>&picplan=<?php echo $pic_plan;?>&area=<?php echo $sect;?>','Lihat Detail <?php echo $no_doc;?>','800','500'); return false;"><i class="material-icons">visibility</i></button>
</td>
</tr>
<?php 
}
?>	
</tbody>
<tfoot>
<tr>	
</tr>
</tfoot>
</table>



</div>
</div>	
</div>	
</div></div>           
 </div></div>
 </section>

 <?php
$secdep=$_GET['s'];
$term=$_GET['t'];
$periode=$_GET['p'];
$obj=$_GET['o'];
$kat=$_GET['k'];
$secdep1=explode("-",$secdep);
 //$term=str_replace("TERM ","",$term);
 //$sec=$secdep1[0];
$noctX=substr($term,-2)."-".$secdep1[0]."-".substr($periode,-2);
$jmdt=0;
if($kat="Additional"){$ad="-ADD";
$sql1="select MAX(RIGHT(no_ctrl_add,3)) as c from bps_budget_add where no_ctrl like '$noctX%'";
}else{$ad="";
 $sql1="select MAX(RIGHT(no_ctrl,3)) as c from bps_budget where jns_budget='$kat' and sect like '$secdep%' and term='$term' and periode='$periode'";}
// echo $sql1;
 $tb_area=odbc_exec($koneksi_lp,$sql1);
 while($baris1=odbc_fetch_array($tb_area)){
$jmdt=odbc_result($tb_area,"c");	  
 }
 $jmdt=$jmdt+1;

 $noct=$noctX.$ad."-".substr("000".$jmdt,-3);
 echo $noct;
 echo "<script>var cou=$noct;alert(cou);</script>";
 ?>
 
<div class="modal fade" id="mdedit" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">EDIT PR</h4></div>
<form action="" id="frmedit" name="frmedit" method="post"  enctype="multipart/form-data">
	<div class="modal-body">
	<div id="dataedit"></div>
	<div class="modal-footer">
	<button type="submit" id="delpr" name="delpr" class="btn btn-link waves-effect">HAPUS</button>
	<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
	</div>
</form>
</div>
</div></div></div>
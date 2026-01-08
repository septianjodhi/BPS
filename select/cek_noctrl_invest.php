<?php
$secdep=$_GET['s'];
$term=$_GET['t'];
$periode=$_GET['p'];
$obj=$_GET['o'];
$kat=$_GET['k'];
$secdep1=explode("-",$secdep);
 //$term=str_replace("TERM ","",$term);
 //$sec=$secdep1[0];
$noctX=substr($term,-2)."-".$secdep1[1]."-".substr($periode,-2);
$jmdt=0;
if($kat="Additional"){$ad="-ADD-IN";
$sql1="select MAX(RIGHT(no_ctrl_add,3)) as c from bps_budget_invest_add where no_ctrl_add like '$noctX%'";
}else{$ad="";
 $sql1="select MAX(RIGHT(no_ctrl,3)) as c from bps_budget_invest where jns_budget='$kat' and sect like '$secdep%' and term='$term' and periode='$periode'";}
// echo $sql1;
 $tb_area=odbc_exec($koneksi_lp,$sql1);
 while($baris1=odbc_fetch_array($tb_area)){
$jmdt=odbc_result($tb_area,"c");	  
 }
 $jmdt=$jmdt+1;

 $noct=$noctX.$ad."-".substr("000".$jmdt,-3);
 //echo $sql1;
 echo "<script>var cou=$noct;alert(cou);</script>";
 ?>

<script>
var cou='<?php echo $noct; ?>';
window.opener.parent.document.getElementById("<?php echo $obj; ?>").value =cou;
        window.close();

    
</script>
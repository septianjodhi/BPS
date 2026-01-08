<?php
$secdep=$_GET['s'];
$term=$_GET['t'];
$periode=$_GET['p'];
$obj=$_GET['o'];
$kat='Additional';
$secdep1=explode("-",$secdep);
 //$term=str_replace("TERM ","",$term);
 //$sec=$secdep1[0];
$noctX=substr($term,-2)."-".$secdep1[1]."-".substr($periode,-2);
$jmdt=0;

 $sql1="select distinct max(cip_no) cip_no  from bps_budget_invest where $secdep%' and term='$term' and periode='$periode'
  union
  select distinct max(cip_no) cip_no  from bps_budget_invest_add where $secdep%' and term='$term' and periode='$periode' ";
// echo $sql1;
 $tb_area=odbc_exec($koneksi_lp,$sql1);
 while($baris1=odbc_fetch_array($tb_area)){
$cip_no=odbc_result($tb_area,"cip_no");
$m_cip=
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
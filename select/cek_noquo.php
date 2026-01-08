<?php
$supp=$_GET['s'];
$periode=$_GET['p'];
$obj=$_GET['o'];
$sql1="select MAX(RIGHT(no_quo,4)) as c from bps_quotation where no_quo like '$supp-$periode%'";
// echo $sql1;
$jmdt=0;
 $tb_area=odbc_exec($koneksi_lp,$sql1);
 while($baris1=odbc_fetch_array($tb_area)){
$jmdt=odbc_result($tb_area,"c");	  
 }
 $jmdt=$jmdt+1;

 $noct=$supp."-".$periode."-".substr("0000".$jmdt,-4);

// echo "<script>var cou=$noct;alert(cou);</script>";
 ?>

<script>
var cou='<?php echo $noct; ?>';
window.opener.parent.document.getElementById("<?php echo $obj; ?>").value =cou;
        window.close();

    
</script>
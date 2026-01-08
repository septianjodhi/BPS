
 <?php
$part_nm=$_GET['p1'];
$part_dtl=$_GET['p2'];
$p3=$_GET['p3'];
if($p3==""){$part_desc="";}else{$part_desc=" and part_desc='$p3'";}
$lp=$_GET['l'];
$sql1="select distinct no_ctrl from bps_budget where lp='$lp' and part_nm='$part_nm' and part_dtl='$part_dtl' $part_desc and expaired>getdate()";
// echo $sql1;
$listctrl="";
 $tb_area=odbc_exec($koneksi_lp,$sql1);
 while($baris1=odbc_fetch_array($tb_area)){
$listctrl=$listctrl.",".odbc_result($tb_area,"no_ctrl");	  
 }
 //echo "<script>var cou=$noct;alert(cou);</script>";
 ?>

<script>
var cou='<?php echo $listctrl; ?>';
window.opener.parent.document.getElementById("no_ctrl").value =cou;
        window.close();

    
</script>
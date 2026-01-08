
 <?php
$term=$_GET['t'];
$periode=$_GET['p'];
$noctrl=$_GET['n'];
$chgadd=$_GET['c'];
$secdep=$_GET['s'];
 $secdep1=explode("-",$secdep);
$sql1="select price,qty from bps_add where no_ctrl='$noctrl'";
// echo $sql1;
$harga=0;$jumlah=0;
 $tb_area=odbc_exec($koneksi_lp,$sql1);
 while($baris1=odbc_fetch_array($tb_area)){
$jumlah=odbc_result($tb_area,"qty");	  
$harga=number_format(odbc_result($tb_area,"qty"),2,".","");
 }

 ?>

<script>
var qty='<?php echo $jumlah; ?>';
var price='<?php echo $harga; ?>';
window.opener.parent.document.getElementById("qty_plan").value =qty;
window.opener.parent.document.getElementById("qty_add").value =qty;
window.opener.parent.document.getElementById("price_plan").value =price;
window.opener.parent.document.getElementById("price_add").value =price;
        window.close();

    
</script>
<?php 
include "../../../koneksi.php";
//$thn = isset($_POST['trm']) ?  $_POST['trm'] :'';
$cip = isset($_POST['cip']) ?  $_POST['cip'] :'';
$noctrl = explode("|",$cip);
//$sql_stk0="select distinct periode from bps_v_dtlinvest where term='$thn' and cip_no='$cip'";
$sql_stk0="select distinct periode from bps_budinvest_dtl where no_ctrl='$noctrl[1]'";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
    $arynama="<option value=''>Pilih Periode</option>";
        while(odbc_fetch_array($tb_stk0))
        {  
        $p2=odbc_result($tb_stk0,"periode");
        $arynama=$arynama."<option value='$p2'>$p2</option>";
        }
        echo $arynama;
?>
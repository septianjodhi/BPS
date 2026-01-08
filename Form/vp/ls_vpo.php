<?php 
include "../../koneksi.php";
$term = isset($_POST['term']) ?  $_POST['term'] :'0';
$periode = isset($_POST['peri']) ?  $_POST['peri'] :'';

$sql_stk0="select distinct vp_no from bps_vp where convert(nvarchar(6),rcv_inv_date,112)='$periode' and not exists(select * from bps_ap where vp_no=bps_vp.vp_no)";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
    $arynama="<option value=''>Pilih VP</option>";
        while(odbc_fetch_array($tb_stk0))
        {  
        $p2=odbc_result($tb_stk0,"vp_no");
        $arynama=$arynama."<option value='$p2'>$p2</option>";
        }
       // echo $sql_stk0;
        echo $arynama;
?>
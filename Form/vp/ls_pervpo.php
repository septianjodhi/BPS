<?php 
include "../../koneksi.php";
$term = isset($_POST['term']) ?  $_POST['term'] :'0';
//$sect = isset($_POST['sec']) ?  $_POST['sec'] :'';

//$sql_stk0="select distinct periode from bps_v_dtlinvest where term='$thn' and cip_no='$cip'";
$sql_stk0="select distinct convert(nvarchar(6),rcv_inv_date,112)[periode] from bps_vp where exists(select * from bps_setTerm where term='$term' and start_term<=bps_vp.rcv_inv_date and finish_term>=bps_vp.rcv_inv_date)";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
    $arynama="<option value=''>Pilih Periode</option>";
        while(odbc_fetch_array($tb_stk0))
        {  
        $p2=odbc_result($tb_stk0,"periode");
        $arynama=$arynama."<option value='$p2'>$p2</option>";
        }
        //echo $sql_stk0;
        echo $arynama;
?>
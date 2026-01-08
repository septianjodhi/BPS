<?php 
include "../../koneksi.php";
$vpno = isset($_POST['vp']) ?  $_POST['vp'] :'0';
//$sect = isset($_POST['sec']) ?  $_POST['sec'] :'';

//$sql_stk0="select distinct periode from bps_v_dtlinvest where term='$thn' and cip_no='$cip'";
$sql_stk0="delete from bps_ap where vp_no='$vpno'";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
        echo "<script>alert('VP $vpno Sudah di hapus')</script>";
?>
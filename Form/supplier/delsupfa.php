<?php 
include "../../koneksi.php";
$kode_supp = isset($_POST['kode']) ?  $_POST['kode'] :'0';
$id_sitesupp = isset($_POST['idss']) ?  $_POST['idss'] :'';

//$sql_stk0="select distinct periode from bps_v_dtlinvest where term='$thn' and cip_no='$cip'";
$sql_stk0="delete from bps_supplier_fa where supp_code='$kode_supp' and supp_site_id='$id_sitesupp'";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
        echo "<script>alert('Kode Supplier $kode_supp - $id_sitesupp Sudah di hapus')</script>";
?>